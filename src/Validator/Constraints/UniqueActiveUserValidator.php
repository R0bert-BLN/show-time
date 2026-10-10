<?php

namespace App\Validator\Constraints;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueActiveUserValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $entityManager)
    {}

    public function validate(mixed $user, Constraint $constraint)
    {
        if (!$user instanceof User) {
            return;
        }

        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $user->getEmail(),
            'isActive' => true
        ]);

        if ($existingUser && $existingUser->getId() !== $user->getId()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('email')
                ->addViolation();
        }
    }
}
