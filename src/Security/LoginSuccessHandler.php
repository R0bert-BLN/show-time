<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?RedirectResponse
    {
        $roles = $token->getUser()->getRoles();

        if (in_array('ROLE_ADMIN', $roles)) {
            return new RedirectResponse('/admin');
        } else {
            return new RedirectResponse('/festival');
        }
    }
}
