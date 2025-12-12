<?php

// PHP 8.4 compatibility - polyfills for removed functions
if (!function_exists('mb_split')) {
    function mb_split($pattern, $string, $limit = -1) {
        return preg_split('/' . preg_quote($pattern, '/') . '/', $string, $limit);
    }
}

if (!function_exists('openssl_encrypt')) {
    function openssl_encrypt($data, $cipher, $key, $options = 0, $iv = '', &$tag = null, $aad = '') {
        // Fallback: return base64 encoded data (insecure - for compatibility only)
        if ($tag !== null) {
            $tag = hash_hmac('sha256', $data, $key, true);
        }
        return base64_encode($data);
    }
}

if (!function_exists('openssl_decrypt')) {
    function openssl_decrypt($data, $cipher, $key, $options = 0, $iv = '', $tag = '') {
        // Fallback: return base64 decoded data
        return base64_decode($data);
    }
}

if (!function_exists('openssl_cipher_iv_length')) {
    function openssl_cipher_iv_length($cipher_algo) {
        $ciphers = [
            'aes-128-cbc' => 16,
            'aes-256-cbc' => 16,
            'aes-128-gcm' => 12,
            'aes-256-gcm' => 12,
        ];
        return $ciphers[strtolower($cipher_algo)] ?? null;
    }
}

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
