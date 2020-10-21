<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("app/home")
 * Class HomeControlller
 * @package App\Controller
 * @author jaures kano <ruddyjaures@mail.com>
 */
class HomeControlller extends AbstractController
{

    /**
     * @Route("/" , name="app_home" )
     * @return Response
     */
    public function index(){
        $module = [];

        $module[] = [
            'nom' => 'GESTION DES UTILISATEURS',
            'description' => 'Espace reserver à la gestion des utilisateurs',
            'image' => '/images/app_image/administration.jpg',
            'icons' => '/images/app_image/admin-icons.png',
            'target' => 'list_utilisateur',
            'granted' => 'ROLE_PENSION'
        ];

        return $this->render('app_dashboard/app_home.html.twig' , [
            'module' => $module
        ]);
    }

}

