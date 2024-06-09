<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\CategoryAnimals;
use App\Entity\FamilyAnimals;
use App\Entity\ServicesType;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin/{_locale}', name: 'admin')]
    public function index(): Response
    {

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->disableDarkMode()
            ->setLocales(['fr'])
            ->setTitle('Tatanimo');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::subMenu('Home', 'fa fa-table-columns')->setSubItems([
                MenuItem::linkToDashboard('Dashboard', 'fa fa-table-columns'),
                MenuItem::linkToUrl('Accueil', 'fa fa-home', '/'),
                MenuItem::linkToRoute('Composants', 'fa-brands fa-react', 'app_admin_components'),
            ]),

            MenuItem::subMenu('C.R.U.D.', 'fa-solid fa-plus')->setSubItems([
                MenuItem::linkToCrud('Services', 'fas fa-list', ServicesType::class),
                MenuItem::linkToCrud('Utilisateurs', 'fas fa-solid fa-circle-user', Users::class),
                MenuItem::linkToCrud('Articles', 'fa-solid fa-newspaper', Articles::class),
                MenuItem::linkToCrud("Catégorie d'animaux", 'fa-solid fa-otter', CategoryAnimals::class),
                MenuItem::linkToCrud("Familles d'animaux", 'fa-solid fa-cat', FamilyAnimals::class)
            ]),
        ];

    }
}
