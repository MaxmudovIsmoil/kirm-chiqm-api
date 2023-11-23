<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data = null, $status = 200) {
            return response()->json([
                'success'  => true,
                'data' => $data,
            ], $status);
        });

        Response::macro('fail', function ($message, $error, $status = 400) {
            return response()->json([
                'success'  => false,
                'message' => $message,
                'errors' => $error,
            ], $status);
        });
    }
}
