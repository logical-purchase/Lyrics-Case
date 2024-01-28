<?php

use Config\Database;

if (!function_exists('generateUuid')) {
    function generateUuid()
    {
        return Database::connect()->query('SELECT UUID() as uuid')->getRow()->uuid;
    }
}