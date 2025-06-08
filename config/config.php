<?php
define('BASE_URL', rtrim((isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']
    . str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));