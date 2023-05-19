<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil_index')]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('accueil/accueil.html.twig', [
            'controller_name' => 'AccueilController',
            'posseder' => $produitRepository->findLatestProducts(5),
        ]);
    }
}
