<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Emprunt;
use App\Entity\User;
use App\Form\AddAccountType;
use App\Form\AddEmpruntType;
use App\Form\EditUserFormType;
use App\Repository\CompteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/add/account', name: 'app_admin_add_account')]
    public function addAcount(Request $request, EntityManagerInterface $entityManager): Response
    {
        $compte = new Compte();

        $form = $this->createForm(AddAccountType::class, $compte);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $compte = $form->getData();
            $entityManager->persist($compte);
            $entityManager->flush();

            $this->addFlash('success', 'Le compte à été crée avec succès');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/addAccount.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/admin/add/loan', name: 'app_admin_add_loan')]
    public function addLoan(Request $request, EntityManagerInterface $entityManager, CompteRepository $compteRepository): Response
    {
        $loan = new Emprunt();

        $form = $this->createForm(AddEmpruntType::class, $loan);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $loan = $form->getData();
            $loan->setEcheance($loan->getDate()->add(new \DateInterval('P'.$loan->getAnnuite().'M')));

            $compteCourantEmprunteur = $compteRepository->findComptesCourantsByUser($loan->getEmprunteur());
            $compteCourantEmprunteur[0]->setMontant($compteCourantEmprunteur[0]->getMontant() + $loan->getMontant());

            $entityManager->persist($loan);
            $entityManager->flush();

            $this->addFlash('success', 'L\'emprunt à a bien été ajouté');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/addLoan.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('/admin/accounts', name: 'app_admin_accounts')]
    public function adminAccounts(UserRepository $userRepository): Response
    {
        return $this->render('admin/accounts.html.twig', [
            'users' => $userRepository->findBy([], ['nom' => 'ASC'])
        ]);
    }


    #[Route('/admin/accounts/{id}/edit', name: 'app_admin_accounts_edit')]
    public function editAccounts(Request $request, User $user, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Le compte a bien été modifié');

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/editUser.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/admin/accounts/{id}/delete', name: 'app_admin_accounts_delete')]
    public function deleteAccounts(User $user, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès.');

        return $this->render('admin/index.html.twig');
    }
}
