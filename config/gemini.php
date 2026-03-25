<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gemini API Key
    |--------------------------------------------------------------------------
    |
    | Here you may specify your Gemini API Key. This key is necessary to
    | authenticate with the Gemini API.
    |
    */

    'api_key' => env('GEMINI_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Gemini Base URL
    |--------------------------------------------------------------------------
    |
    | Here you may specify the base URL for the Gemini API.
    |
    */

    'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta/'),

    /*
    |--------------------------------------------------------------------------
    | Gemini Headless
    |--------------------------------------------------------------------------
    |
    | Here you may specify if you want to run Gemini in headless mode.
    |
    */

    'headless' => false,

];