<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/accueil/listepro', name: 'app_listepro')]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/listepro.html.twig', [
            'controller_name' => 'ProduitController',
            'posseder' => $produitRepository->findAll(),
        ]);
    }
    #[Route('/accueil/listepro/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_listepro', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/addproduit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
    #[Route('accueil/listepro/{id}', name: 'app_produit_detail')]
    public function detail($id, ProduitRepository $produitRepository, CommentaireRepository $commentaireRepository): Response
    {
        $produit = $produitRepository->find($id);
        $commentaire = $commentaireRepository->findBy(['produit' => $produit]);

        return $this->render('produit/produit.html.twig', [
            'produit' => $produit,
            'commentaire' => $commentaire,
        ]);
    }
    #[Route('/accueil/listepro/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_listepro', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/editproduit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
    #[Route('/accueil/listepro/{id}/delete', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_listepro', [], Response::HTTP_SEE_OTHER);
    }
}