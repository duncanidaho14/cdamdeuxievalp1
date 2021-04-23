<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Evaluationpun');
    }

    public function configureMenuItems(): iterable
    {
        return [
            yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            yield MenuItem::linkToCrud('User', 'fas fa-user', User::class),
            yield MenuItem::linkToCrud('Produit', 'fas fa-list', Produit::class),
            yield MenuItem::linkToCrud('Produit', 'fas fa-list', Image::class)
        ];
    }
}
