<?php

namespace App\Controller\Admin;

use App\Entity\Shift;
use App\Entity\User;
use RuntimeException;
use App\Entity\Business;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use App\Controller\Admin\Interfaces\DashboardControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController implements DashboardControllerInterface
{

    /************************************************* CONSTANTS **************************************************/

    /************************************************* PROPERTIES *************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /************************************************** ROUTING ***************************************************/

    /**
     * @Route("/{_locale}/admin", name="admin")
     *
     * @inheritDoc
     * @return Response Response
     */
    public function index(): Response
    {
        return parent::index();
    }

    /**
     * @Route("/login", name="login")
     *
     * @inheritDoc
     * @return Response Response
     */
    public function loginAction(): Response
    {
        return $this->render('pages/login.html.twig');
    }

    /**
     * @Route("/logout", name="logout")
     *
     * @inheritDoc
     * @return Response Response
     */
    public function logoutAction(): Response
    {
        throw new RuntimeException('Esta ruta no debe ser llamada directamente.');
    }

    /*********************************************** PUBLIC METHODS ***********************************************/

    /**
     * @inheritDoc
     * @return Dashboard Dashboard
     */
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BusinessAPP');
    }

    /**
     * @inheritDoc
     * @return iterable iterable
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Inicio', 'fa fa-home');

        $roles = $this->getUser() !== NULL ? $this->getUser()->getRoles() : array();
        if (in_array(User::ROLE_ADMIN, $roles) || in_array(User::ROLE_WORKER, $roles)):
            yield MenuItem::section('Config. Negocio', 'fas fa-cog');
            yield MenuItem::linkToCrud('Negocios', 'fas fa-briefcase', Business::class);
            yield MenuItem::linkToCrud('Turnos', 'fas fa-clock', Shift::class);
            yield MenuItem::section('Config. Usuarios', 'fas fa-cog');
            yield MenuItem::linkToCrud('Usuarios', 'fas fa-user', User::class);
        endif;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}
