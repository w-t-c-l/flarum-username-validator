<?php

namespace WTCL\UsernameValidator;

use Flarum\Extend;
use WTCL\UsernameValidator\Validator\UsernameModerator;
use Flarum\User\Event\Saving;
use Flarum\User\UserValidator;

return [
    // Use the event dispatcher to modify validation rules
    (new Extend\Event())
        ->listen(Saving::class, UsernameModerator::class),
        
    // Override Flarum's default username validation rules
    (new Extend\Validator(UserValidator::class))
        ->configure(function ($flarumValidator, $validator) {
            // Get the existing rules
            $rules = $validator->getRules();
            
            // Find and modify the username min length rule
            if (isset($rules['username'])) {
                foreach ($rules['username'] as $key => $rule) {
                    // Replace the min:3 rule with min:1
                    if (strpos($rule, 'min:') === 0) {
                        $rules['username'][$key] = 'min:1';
                    }
                }
                $validator->setRules($rules);
            }
        }),
];
