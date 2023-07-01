<?php

namespace App\Controller;

use App\Repository\BlogpostRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProjetRepository $projetRepository, BlogpostRepository $blogpostRepository): Response
    {

        $projets = $projetRepository->showProjetClientSide();
        $blogposts = $blogpostRepository->showBlogPostClientSide();
        return $this->render('home/index.html.twig', [
            'projets' => $projets,
            'blogposts' =>  $blogposts
        ]);
    }
}
