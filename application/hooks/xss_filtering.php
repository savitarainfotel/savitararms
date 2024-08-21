<?php defined('BASEPATH') OR exit('No direct script access allowed');

function xss_filtering() {
    foreach ($_POST as $pk => $pd) {
        $_POST[$pk] = cleanInput($pd);
    }

    foreach ($_GET as $gk => $gd) {
        $_GET[$gk] = cleanInput($gd);
    }
}

function cleanInput($input) {
    if (is_array($input)) {
        // If the value is an array, clean each element
        foreach ($input as $key => $value) {
            $input[$key] = cleanInput($value);
        }
    } else {
        // Remove leading and trailing white spaces
        $input = trim($input);
        
        // Remove backslashes
        $input = stripslashes($input);
        
        // Convert special characters to HTML entities
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    
    return $input;
}