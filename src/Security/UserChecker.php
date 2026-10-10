<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user->isVerified()) {
            throw new CustomUserMessageAccountStatusException('Your account is not verified.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        // Nothing to do
    }
}
