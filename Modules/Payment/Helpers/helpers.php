<?php

if (! function_exists('get_payment_setting')) {
    function get_payment_setting(string $key, $type = null, $default = null)
    {
        if (! empty($type)) {
            $key = 'payment_' . $type . '_' . $key;
        } else {
            $key = 'payment_' . $key;
        }

        return setting($key, $default);
    }
}

