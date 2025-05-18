<?php

if (!function_exists('getUserImage')) {
    /**
     * @return string
     */
    function getUserImage(): string
    {
        return asset('storage/' . auth()->user()->image_path ?? \App\Models\User::$defaultManImage);
    }
}
