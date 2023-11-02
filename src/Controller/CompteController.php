<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    #[Route('/compte', name: 'app_compte')]
    public function index(): Response
    {
        if($this->getUser() == null){
            return $this->redirectToRoute("app_register");
        }

        $user = $this->getUser();

        return $this->render('compte/index.html.twig', [
            'comptes' => $user->getComptes(),
        ]);
    }
}
