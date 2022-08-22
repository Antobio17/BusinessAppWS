<?php

namespace App\Controller\Admin;

use App\Entity\Appointment;
use App\Entity\BusinessService;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\SocialImage;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\ComparisonType;
use RuntimeException;
use App\Entity\Shift;
use App\Entity\Image;
use App\Entity\Business;
use App\Entity\HomeConfig;
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
        if (
            $this->getUser() === NULL || (
                !in_array(User::ROLE_WORKER, $this->getUser()->getRoles())
                && !in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())
            )
        ):
            $response = $this->redirectToRoute('login');
        else:
            $response = $this->render('admin/index.html.twig');
        endif;

        return $response;
    }

    /**
     * @Route("/{_locale}/admin/login", name="login")
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
            yield MenuItem::linkToCrud('Home', 'fas fa-home', HomeConfig::class);
            yield MenuItem::linkToCrud('Red Social', 'fas fa-camera', SocialImage::class);
            yield MenuItem::linkToCrud('Servicios', 'fas fa-tag', BusinessService::class);
            yield MenuItem::section('Config. Tienda', 'fas fa-cog');
            yield MenuItem::linkToCrud('Categorías', 'fas fa-folder-open', Category::class);
            yield MenuItem::linkToCrud('Productos', 'fas fa-shopping-bag', Product::class);
            yield MenuItem::section('Config. Citas', 'fas fa-cog');
            yield MenuItem::linkToCrud('Citas', 'fas fa-calendar-alt', Appointment::class);
            $startDate = date_create()->setTime(0, 0);
            $endDate = date_create()->setTime(23, 59);
            yield MenuItem::linkToCrud('Pendientes', 'fas fa-hourglass-start', Appointment::class)
                ->setQueryParameter('filters', array(
                    'status' => array(
                        'comparison' => ComparisonType::EQ,
                        'value' => Appointment::STATUS_PENDING,
                    ),
                    'bookingDateAt' => array(
                        'comparison' => ComparisonType::BETWEEN,
                        'value' => sprintf(
                            '%sT%s', $startDate->format('Y-m-d'), $startDate->format('H:i')
                        ),
                        'value2' => sprintf(
                            '%sT%s', $endDate->format('Y-m-d'), $endDate->format('H:i')
                        ),
                    )
                ));
            yield MenuItem::section('Config. Pedidos', 'fas fa-cog');
            yield MenuItem::linkToCrud('Pedidos', 'fas fa-shopping-cart', Order::class);
            yield MenuItem::linkToCrud('Pendientes', 'fas fa-hourglass-start', Order::class)
                ->setQueryParameter('filters', array(
                    'status' => array(
                        'comparison' => ComparisonType::EQ,
                        'value' => Order::STATUS_PENDING,
                    ),
                ));
            yield MenuItem::linkToCrud('En Preparación', 'fas fa-hourglass-half', Order::class)
                ->setQueryParameter('filters', array(
                    'status' => array(
                        'comparison' => ComparisonType::EQ,
                        'value' => Order::STATUS_PREPARING,
                    ),
                ));
            yield MenuItem::section('Config. Usuarios', 'fas fa-cog');
            yield MenuItem::linkToCrud('Usuarios', 'fas fa-user', User::class);
        endif;
    }

    /*********************************************** STATIC METHODS ***********************************************/

}
