<?php

if (! function_exists('setting')) {
    /**
     * Get the specified setting value.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return \App\Models\Setting::get($key, $default);
    }
}
