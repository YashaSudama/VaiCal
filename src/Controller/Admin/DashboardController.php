<?php

namespace App\Controller\Admin;

use App\Entity\City;
use App\Entity\Device;
use App\Entity\EventDescription;
use App\Entity\NewCity;
use App\Entity\User;
use App\Entity\Year;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $newCityCount = $this->container->get('doctrine')->getRepository(NewCity::class)->count([]);

        return $this->render(
            'admin-home.html.twig',
            ['newCityCount' => $newCityCount]
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('VaiCal');

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Cities', 'fas fa-city', City::class);
        yield MenuItem::linkToCrud('Years', 'fas fa-clock', Year::class);
        yield MenuItem::section('Upload', 'fas fa-plug');
        yield MenuItem::linkToRoute('Upload city file', 'fas fa-upload', 'year_index');
        yield MenuItem::linkToCrud('Event description', 'fas fa-book', EventDescription::class);
        yield MenuItem::section('Incoming requests', 'fas fa-inbox');
        yield MenuItem::linkToCrud('New city', 'fas fa-download', NewCity::class);
        yield MenuItem::section('Devices', 'fas fa-plug');
        yield MenuItem::linkToCrud('Devices', 'fas fa-phone', Device::class);

    }
}
