<?php

namespace App\Controller\Admin;

use App\Repository\BookRepository;
use App\Repository\BorrowingRepository;
use App\Repository\UserRepository;


use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
       public function __construct(
    private BookRepository $bookRepository,
    private UserRepository $userRepository,
    private BorrowingRepository $borrowingRepository,
) {}
 

    public function index(): Response
    {
       
      return $this->render('admin/dashboard.html.twig', [
        'bookCount'        => $this->bookRepository->count([]),
        'userCount'        => $this->userRepository->count([]),
        'activeBorrowings' => $this->borrowingRepository->count(['returnedAt' =>null]),
    ]);
    
    
        return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // return $this->redirectToRoute('admin_user_index');

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {

    return Dashboard::new()
        ->setTitle('📚 Bibliotech — Administration')
        ->setFaviconPath('favicon.ico')
        ->renderContentMaximized();  // Le contenu utilise toute la largeur

        return Dashboard::new()
            ->setTitle('Mon Projet2');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
         yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-tachometer-alt');

    yield MenuItem::section('Catalogue');
    yield MenuItem::linkTo(BookCrudController::class, 'Livres', 'fa fa-book');
    yield MenuItem::linkTo(AuteurCrudController::class, 'Auteurs', 'fa fa-pen-nib');
    yield MenuItem::linkTo(CategoryCrudController::class, 'Catégories', 'fa fa-tag');

    yield MenuItem::section('Utilisateurs & Emprunts');
    yield MenuItem::linkTo(UserCrudController::class, 'Utilisateurs', 'fa fa-users');
    yield MenuItem::linkTo(BorrowingCrudController::class, 'Emprunts', 'fa fa-book-reader');

    yield MenuItem::section('Navigation');
    yield MenuItem::linkToRoute('Retour au site', 'fa fa-arrow-left', 'app_home');
        // yield MenuItem::linkTo(SomeCrudController::class, 'The Label', 'fas fa-list');
    }
}
