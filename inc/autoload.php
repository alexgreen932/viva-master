<?php

// dd('autoloader');


if (!function_exists('jet_autoloader')) {
    function jet_autoloader($classes = [], $path = '')
    {
        if (empty($classes) || !is_array($classes)) {
            echo "<pre>Jet Autoloader message: Invalid or empty classes array provided!</pre>";
            return;
        }

        if (empty($path) || !is_string($path)) {
            echo "<pre>Jet Autoloader message: Invalid or empty path provided!</pre>";
            return;
        }

        foreach ($classes as $class) {
            $file = rtrim($path, '/') . '/' . $class . '.php';
            if (file_exists($file)) {
                require_once $file;
                if (class_exists($class) && !class_exists('Jet_Autoloader_Initialized_' . $class)) {
                    new $class();
                    // Prevent reinitialization in future calls
                    class_alias($class, 'Jet_Autoloader_Initialized_' . $class);
                }
            } else {
                echo "<pre>Jet Autoloader message: File not found for class $class at $file!</pre>";
            }
        }
    }
}

// Example usage
$classes = [
    'LoyaltyProgramDiscounts',
    'LoyaltyProgramService',
    'LoyaltyProgramCalculator',
    'LoyaltyProgramSidebarData',
    'CompanyRegister',
    'CompanyProfile',
    'CompanySwitcher',
    'SetLoyaltyLevel',
    'EmailOverrideForSubaccounts',
    'LoyaltyProgramInfoShortcode',
];
$path = get_theme_file_path() . '/classes/LoyaltyProgram/';

jet_autoloader($classes, $path);

