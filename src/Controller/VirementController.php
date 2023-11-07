<?php

namespace App\Controller;

use App\Entity\Virement;
use App\Form\VirementType;
use App\Repository\CompteRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VirementController extends AbstractController
{
    #[Route('/virements', name: 'app_virements')]
    public function index(): Response
    {
        return $this->render('virement/index.html.twig', [
            'controller_name' => 'VirementController',
        ]);
    }

    #[Route('/virements/add', name: 'app_virements_add')]
    public function addVirement(Request $request, CompteRepository $compteRepository, EntityManagerInterface $entityManager): Response
    {
        $virement = new Virement();

        $form = $this->createForm(VirementType::class, $virement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $beneficiaire = $form->get('utilisateurBeneficiaire')->getData();

            $compteCourantBeneficiaire = $compteRepository->findComptesCourantsByUser($beneficiaire);
            $compteCourantEmetteur = $compteRepository->findComptesCourantsByUser($this->getUser());

            $virement = $form->getData();
            $virement->setCompteBeneficiaire($compteCourantBeneficiaire[0]);
            $virement->setCompteEmetteur($compteCourantEmetteur[0]);

            $compteCourantBeneficiaire[0]->setMontant($compteCourantBeneficiaire[0]->getMontant() + $virement->getMontant());
            $compteCourantEmetteur[0]->setMontant($compteCourantEmetteur[0]->getMontant() - $virement->getMontant());


            $entityManager->persist($virement);
            $entityManager->flush();
            return $this->redirectToRoute('app_compte');

        }

        return $this->render('virement/addVirement.html.twig', [
            'form' => $form
        ]);
    }
}
