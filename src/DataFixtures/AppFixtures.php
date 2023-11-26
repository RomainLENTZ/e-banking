<?php

namespace App\DataFixtures;

use App\Entity\Compte;
use App\Entity\Emprunt;
use App\Entity\User;
use App\Entity\Virement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    private function loadUsers(ObjectManager $manager, UserPasswordHasherInterface $userPasswordHasher): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $user = new User(true);
            $user
                ->setEmail("test{$i}@gmail.com")
                ->setPassword($userPasswordHasher->hashPassword($user, '123456'))
                ->setNom("Test")
                ->setPrenom("Numero".$i);
            if ($i === 1) {
                $user->setRoles(['ROLE_ADMIN']);
            }
            $manager->persist($user);
        }
        $manager->flush();
    }

    private function loadCompte(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 1; $i <= 3; $i++) {
            $compte = new Compte("Compte épargne", true);
            $compte->setDetenteur($users[$i-1]);
            $manager->persist($compte);
        }
        $manager->flush();
    }

    private function loadEmprunt(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 1; $i <= 6; $i++) {
            $emprunt = new Emprunt();
            $emprunt->setMontant(rand(1000, 100000));
            $emprunt->setEmprunteur($users[$i%2]);
            $emprunt->setAnnuite(rand(12, 36));
            $emprunt->setEcheance($emprunt->getDate()->add(new \DateInterval('P'.$emprunt->getAnnuite().'M')));
            $emprunt->setTaux(1+(rand(0, 10)/10));
            $manager->persist($emprunt);
        }
        $manager->flush();
    }

    private function loadVirement(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        for ($i = 1; $i <= 6; $i++) {
            $virement = new Virement();
            $virement->setMontant(rand(10, 1000));
            $virement->setCompteEmetteur($manager->getRepository(Compte::class)->findComptesCourantsByUser($users[$i%3])[0]);
            $virement->setCompteBeneficiaire($manager->getRepository(Compte::class)->findComptesCourantsByUser($users[($i+1)%3])[0]);
            $manager->persist($virement);
        }
        $manager->flush();
    }


    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager, $this->passwordHasher);
        $this->loadCompte($manager);
        $this->loadEmprunt($manager);
        $this->loadVirement($manager);
        $manager->flush();
    }
}
