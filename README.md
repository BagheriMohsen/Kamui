<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/BagheriMohsen/Kamui/master/art/kamui.jpeg" width="400">
    </a>
</p>

<p align="center">
    <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-8.x-blue" alt="License"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/badge/Laravel-9.x-red" alt="License"></a>
    <a href="https://packagist.org/packages/mohsenbagheri/kamui"><img src="https://img.shields.io/badge/Packagist-v1-orange" alt="License"></a>
    <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# About Kamui

This service helps you to communicate between services

## Install
    composer require spatie/laravel-signal-aware-command
    composer require mohsenbagheri/kamui
    php artisan vendor:publish
    php artisan migrate
    
## Basic usage
 
routes/Web.php 

    Route::get('publish', [\App\Http\Controllers\TestController::class, 'publish'])->name('publish');
    Route::get('subscribe', [\App\Http\Controllers\TestController::class, 'subscribe'])->name('subscribe');

controller

    <?php
        
    namespace App\Http\Controllers;
    
    use Illuminate\Support\Facades\Log;
    use Mohsenbagheri\Kamui\Services\Communication\CommunicateRedisService;
    
    class TestController extends Controller
    {

        public function __construct(private CommunicateRedisService $communicateRedisService)
        {
        }
    
        public function publish()
        {
            $this->communicateRedisService->send('test', ['message' => 'hello world!']);
    
            return 'ok';
        }
    
        public function subscribe(object $data)
        {
            Log::info("data", $data);
        }
    }

command console 

    php artisan worker:redis test subscribe

or 

    php artisan worker:rabbitmq test subscribe

#Grpc

Coming soon!
