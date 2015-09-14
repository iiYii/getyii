<?php

function env($envName, $default = false)
{
    $envName = getenv($envName);

    return $envName === false ? $default : $envName;
}

/**
 * @param $message
 * @param bool|true $debug
 */
function pr($message, $debug = true)
{
    echo '<pre>';
    print_r($message);
    echo '</pre>';
    if ($debug) {
        die;
    }
}