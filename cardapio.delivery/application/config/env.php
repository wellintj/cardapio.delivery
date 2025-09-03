<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Env
{
    static function env()
    {
        $envFilePath = __DIR__ . '/ci-env';
        // Check if the .env file exists
        if (file_exists($envFilePath)) {
            $envContent = file_get_contents($envFilePath);

            $envVariables = parse_ini_string($envContent);
            // Set environment variables
            foreach ($envVariables as $key => $value) {
                $_SERVER[$key] = $value;
                $_ENV[$key] = $value;
            }
        }
    }

   
}
