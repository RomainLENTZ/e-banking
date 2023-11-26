<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class LoanVoter extends Voter
{
    public const PAY = 'pay';


    protected function supports(string $attribute, mixed $subject): bool
    {
        return $attribute == self::PAY
            && $subject instanceof \App\Entity\Emprunt;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        if($attribute == self::PAY){
            if($subject->getEmprunteur() == $user){
                return true;
            }
        }

        return false;
    }
}
