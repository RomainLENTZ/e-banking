<?php

namespace App\Controller;

use App\Entity\Virement;
use App\Form\VirementType;
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
    public function addVirement(Request $request): Response
    {
        $virement = new Virement();

        $form = $this->createForm(VirementType::class, $virement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            dd($form->getData());
            $virement = $form->getData();
            dd($virement);
            /*
            $entityManager->persist($task);
            $entityManager->flush();
            return $this->redirectToRoute('app_to_do_list_tasks', ['id' => $toDoList->getId()]);
            */
        }

        return $this->render('virement/addVirement.html.twig', [
            'form' => $form
        ]);
    }
}
