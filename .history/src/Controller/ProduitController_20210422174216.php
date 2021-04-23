<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * Undocumented function
     * 
     * @Route("/produit/edit/{id<\d+>}", name="produit_edit", methods={"GETPOST"})
     * @Security("is_granted('ROLE_USER') and user === produit.getFullName()", message="Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier") 
     * 
     * @param Produit $produit
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(Produit $produit, Request $request, EntityManagerInterface $manager, $id): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        dd($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($produit);
            $manager->flush();
        }

        return $this->render('produit/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/produit/create", name="produit_create")
     * @IsGranted("ROLE_USER")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $produit->setUserOwner($user);

            $manager->persist($produit);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le produit a bien été crée !'
            );
        }

        return $this->render('produit/index.html.twig', [
            'produit' => $form->createView()
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
