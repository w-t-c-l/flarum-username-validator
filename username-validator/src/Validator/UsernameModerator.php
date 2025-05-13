<?php

namespace WTCL\UsernameValidator\Validator;

use Flarum\User\Event\Saving;
use Flarum\Foundation\ValidationException;
use Illuminate\Support\Arr;

class UsernameModerator
{
    /**
     * @param Saving $event
     * @throws ValidationException
     */
    public function handle(Saving $event)
    {
        $user = $event->user;
        $data = $event->data;
        
        // Only proceed if the username is being changed
        if (!isset($data['attributes']['username'])) {
            return;
        }
        
        $username = $data['attributes']['username'];
        
        // Check username length (up to 12 characters)
        if (mb_strlen($username) > 12) {
            throw new ValidationException([
                'username' => 'Username cannot exceed 12 characters.'
            ]);
        }
        
        // Check if username contains only allowed characters (letters, numbers, spaces)
        if (!preg_match('/^[a-zA-Z0-9 ]+$/', $username)) {
            throw new ValidationException([
                'username' => 'Username can only contain letters, numbers, and spaces.'
            ]);
        }
        
        // Check for leading spaces
        if (substr($username, 0, 1) === ' ') {
            throw new ValidationException([
                'username' => 'Username cannot start with a space.'
            ]);
        }
        
        // Check for trailing spaces
        if (substr($username, -1) === ' ') {
            throw new ValidationException([
                'username' => 'Username cannot end with a space.'
            ]);
        }
        
        // Check for consecutive spaces
        if (strpos($username, '  ') !== false) {
            throw new ValidationException([
                'username' => 'Username cannot contain consecutive spaces.'
            ]);
        }
    }
}
