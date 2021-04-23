<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    
    /**
     * @Route("/produit/create", name="produit_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form);
        }

        return $this->render('produit/index.html.twig', [
            'produit' => $form->createView
        ]);
    }

    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $produitRepo): Response
    {
        $produit = $produitRepo->findAll();

        return $this->render('produit/index.html.twig', [
            'produit' => $produit
        ]);
    }

}
