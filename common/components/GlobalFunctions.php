<?php

function env($envName, $default = false)
{
    $envName = getenv($envName);

    return $envName === false ? $default : $envName;
}
