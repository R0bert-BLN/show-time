<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class UniqueActiveUser extends Constraint
{
    public $message = 'An active account with this email already exists.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
