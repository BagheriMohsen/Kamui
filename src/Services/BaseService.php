<?php


namespace Mohsenbagheri\Kamui\Services;

use Mohsenbagheri\Kamui\Repositories\CommunicationLogRepository;

abstract class BaseService
{

    abstract public function repository(): string;

    public $repository;

    public function __construct()
    {
        $this->makeRepository();
    }

    public function makeRepository()
    {
        $this->repository = resolve($this->repository());
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(string $id, array $data): int
    {
        return $this->repository->update($id, $data);
    }

    public function updateWithColumn(string $column, string $value, array $data): int
    {
        return $this->repository->updateWithColumn($column, $value, $data);
    }

    public function find(string $column, string $value)
    {
        return $this->repository->find($column, $value);
    }

    public function firstOrFail(string $column, string $value)
    {
        return $this->repository->firstOrFail($column, $value);
    }

    public function delete(string $column, string $value)
    {
        return $this->repository->delete($column, $value);
    }

    public function get($with = [])
    {
        return $this->repository->get($with);
    }

    public function getWithPaginate(null|array $queries = null, array $with = [], $sort = "created_at", $direction = "desc", $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->repository->getWithPaginate($queries, $with, $sort, $direction, $perPage);
    }

    public function firstOrCreate($queries, $data)
    {
        return $this->repository->firstOrCreate($queries, $data);
    }

    public function search($value, $sort = 'created_at', $direction = 'desc', $perPage = 15)
    {
        return $this->repository->search($value, $sort, $direction, $perPage);
    }
}
