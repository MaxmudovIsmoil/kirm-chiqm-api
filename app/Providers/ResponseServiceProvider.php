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
        Response::macro('success', function ($data = null) {
            return response()->json([
                'errors'  => false,
                'data' => $data,
            ]);
        });

        Response::macro('fail', function ($message, $status = 400) {
            return response()->json([
                'errors'  => true,
                'message' => $message,
            ], $status);
        });
    }
}
