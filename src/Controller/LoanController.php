<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\PayLoanType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LoanController extends AbstractController
{
    #[Route('/loan', name: 'app_loan')]
    public function index(): Response
    {
        return $this->render('loan/index.html.twig', [
            'user_loans' => $this->getUser()->getEmprunts(),
        ]);
    }


    #[Route('/loan/{id}/pay', name: 'app_pay_loan')]
    #[IsGranted('pay', 'emprunt', 'Oooops !!! Tu essaye de rembourser un pret qui ne t\'appartiens pas...', 404)]
    public function payLoan(Request $request, Emprunt $emprunt, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PayLoanType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $montantRembourse = $form->get('montant')->getData();
            if($emprunt->getMotantRembourse()+$montantRembourse > $emprunt->getMontant()){
                $this->addFlash('error', 'Vous êtes sympa mais là vous souhaitez rembourser plus que ce que vous avez emprunté... 🥲 On n\'en demande pas autant 😀');
                return $this->redirectToRoute('app_pay_loan',  ['id' => $emprunt->getId()]);
            }

            $emprunt->setMotantRembourse($emprunt->getMotantRembourse() + $montantRembourse);
            $entityManager->flush();

            return $this->redirectToRoute("app_loan");
        }

        return $this->render('loan/payLoan.html.twig', [
            'form' => $form
        ]);
    }
}
