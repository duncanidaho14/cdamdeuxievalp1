<?php

namespace App\Controller;

use App\Entity\User;
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
     * @Route("/produit/{id<\d+>}", name="produit_show")
     * @param ProduitRepository $produitRepo
     * @param [type] $id
     * @return Response
     */
    public function show(ProduitRepository $produitRepo, $id): Response
    {
        $produit = $produitRepo->findOneBy(array('id' => $id));

        return $this->render('produit/show.html.twig', [
            'produit' => $produit
        ]);
    }

    /**
     * Undocumented function
     * 
     * @Route("/produit/edit/{$id}", name="produit_edit", methods={"GET", "POST", "PATCH"})
     * @Security("is_granted('ROLE_USER') and user == produit.getFullName()", message="Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier") 
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

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($produit);
            $manager->flush();
        }

        return $this->render('produit/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Remove produit
     * @Route("/produit/remove/{id}", name="produit_remove")
     * @Security("is_granted('ROLE_USER') and user == produit.getImages()", message="Vous n'avez pas le droit d'accéder à cette ressource")
     * @param Produit $produit
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function removeProduit(Produit $produit, EntityManagerInterface $manager): Response
    {
        
        $manager->remove($produit);
        $manager->flush();
        return $this->redirectToRoute('home');
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
