<?php

namespace Mohsenbagheri\Kamui\Repositories;

use Illuminate\Container\Container as Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

abstract class BaseRepository
{

    protected Model $model;

    public function __construct(protected Application $app)
    {
        $this->makeModel();
    }

    abstract public function getFieldsSearchable(): array;

    abstract public function model(): string;

    public function makeModel(): Model
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->newQuery();
    }

    public function create(array $data): Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->query()->create($data);
    }

    public function update(string $id, array $data)
    {
        $row =  $this->query()->where("id", $id)->first();
        if(is_null($row)) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        return $row->update($data);
    }

    public function updateWithColumn(string $column, string $value, array $data): int
    {
        return $this->query()->where($column, $value)->update($data);
    }

    public function find(string $column, string $value): Model|null
    {
        return $this->query()->where($column, $value)->first();
    }

    public function firstOrFail(string $column, string $value): Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->query()->where($column, $value)->firstOrFail();
    }

    public function delete(string $column, string $value)
    {
        return $this->query()->where($column, $value)->delete();
    }

    public function get($with=[]): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->query()->with($with)->get();
    }

    public function getWithPaginate(null|array $queries=null, array $with=[], $sort="created_at",
                                    $direction="desc", $perPage=15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->query()
            ->with($with)
            ->when($queries, function ($q, $queries) {
                return $q->where($queries);
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage);
    }

    public function firstOrCreate($queries,$data): Model
    {
        return $this->query()->firstOrCreate($queries,$data);
    }

    public function search($value, $sort='created_at', $direction='desc', $perPage=15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $fields = $this->getFieldsSearchable();
        $query =  $this->query();
        foreach ($fields as $field) {
            $query->where($field, 'LIKE', "%{$value}%");
        }

        return $query
            ->orderBy($sort, $direction)
            ->paginate($perPage);
    }


}
