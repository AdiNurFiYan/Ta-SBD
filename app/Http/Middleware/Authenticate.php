<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // Redirect based on URL prefix
            if ($request->is('member/*')) {
                return route('member.login');
            } elseif ($request->is('admin/*')) {
                return route('admin.login');
            }
            return route('login');
        }
        return null;
    }
}