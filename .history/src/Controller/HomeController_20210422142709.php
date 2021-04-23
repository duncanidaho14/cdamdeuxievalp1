<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(ProduitRepository $produitRepo, ImageRepository $imageRepo): Response
    {
        $produit = $produitRepo->findAll();
        $images = $imageRepo->findAll();

        return $this->render('home/index.html.twig', [
            'produit' => $produit,
            'images' => $images,
        ]);
    }


    public function FunctionName(Type $var = null)
    {
        # code...
    }
}
