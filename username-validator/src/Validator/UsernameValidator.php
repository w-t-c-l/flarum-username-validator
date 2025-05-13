<?php

namespace WTCL\UsernameValidator;

class UsernameValidator
{
    /**
     * Validates a username according to our rules
     * 
     * @param string $username The username to validate
     * @return bool|string True if valid, or error message if invalid
     */
    public static function validate($username)
    {
        // Check minimum username length (at least 1 character)
        if (mb_strlen($username) < 1) {
            return 'Username must have at least 1 character.';
        }
        
        // Check username length (up to 12 characters)
        if (mb_strlen($username) > 12) {
            return 'Username cannot exceed 12 characters.';
        }
        
        // Check if username contains only allowed characters (letters, numbers, spaces)
        if (!preg_match('/^[a-zA-Z0-9 ]+$/', $username)) {
            return 'Username can only contain letters, numbers, and spaces.';
        }
        
        // Check for leading spaces
        if (substr($username, 0, 1) === ' ') {
            return 'Username cannot start with a space.';
        }
        
        // Check for trailing spaces
        if (substr($username, -1) === ' ') {
            return 'Username cannot end with a space.';
        }
        
        // Check for consecutive spaces
        if (strpos($username, '  ') !== false) {
            return 'Username cannot contain consecutive spaces.';
        }
        
        return true;
    }
}
