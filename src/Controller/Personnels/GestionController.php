<?php


namespace App\Controller\Personnels;


use App\Entity\Utilisateur;
use App\Form\UtilisateurRolesType;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("gestion-personnels")
 * Class GestionController
 * @package App\Controller\Personnels
 * @author jaures kano <ruddyjaures@mail.com>
 */
class GestionController extends AbstractController
{
    /**
     * @Route("/list/" , name="list_utilisateur")
     * @param UtilisateurRepository $utilisateurRepository
     * @return Response
     */
    public function index(UtilisateurRepository $utilisateurRepository){
        return $this->render('personnel/gestion/list_personnels.html.twig' , [
            'personnels' => $utilisateurRepository->findAll()
        ]);
    }

    /**
     * @Route("/ajout-du-personnel/" , name="ajout_personnel" )
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function setPersonnel( Request $request ,
                                  UserPasswordEncoderInterface $passwordEncoder )
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm( UtilisateurType::class , $utilisateur );
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid() ){
            $em = $this->getDoctrine()->getManager();
            $utilisateur->setInsertAt(new DateTime());
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword( $utilisateur ,
                    123456 ) );
            $this->addFlash('success' , 'Ajout de l\'utilisateur à bien été effectuer !');
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('ajout_personnel');
        }

        return $this->render('personnel/gestion/add_user.html.twig' , [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/gestion-des-roles/" , name="gestion_des_roles")
     * @Route("/gestion-des-roles/783430{id}834/utilisateur" , name="gestion_user_roles")
     * @param Request $request
     * @param UtilisateurRepository $utilisateurRepository
     * @param Utilisateur|null $utilisateur
     * @return Response|void
     */
    public function roleGestion( Request $request , UtilisateurRepository $utilisateurRepository ,
                                 Utilisateur $utilisateur = null ){
        $form = $this->createForm(UtilisateurRolesType::class , $utilisateur );
        $form->handleRequest($request);

        if( $form->isSubmitted() and $form->isValid() ){
            $em = $this->getDoctrine()->getManager();

            $em->persist($utilisateur);
            $em->flush();

            $this->addFlash('success' , 'Edition du role a bien ete effectuer !');
            return $this->redirectToRoute('gestion_des_roles');
        }

        return $this->render('personnel/gestion/gestion_des_roles.html.twig' , [
            'form' => $form->createView(),
            'utilisateur' => $utilisateur,
            'utilisateurs' => $utilisateurRepository->findAll()
        ]);
    }


    /**
     * @Route("/password_reset/{id}/" , name="password_reset")
     * @param Utilisateur $utilisateur
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function indexPasswordReset( Utilisateur $utilisateur ,
                                        Request $request , UserPasswordEncoderInterface $passwordEncoder ){

        if( $request->request->count() >  0 ){

            $password = $request->get('password');
            $em = $this->getDoctrine()->getManager();
            if ($passwordEncoder->isPasswordValid( $this->getUser() , $password)) {
                $utilisateur->setPassword( $passwordEncoder->encodePassword( $utilisateur ,
                        123456 ) );
                $em->persist($utilisateur);
                $em->flush();
                $this->addFlash('success' , 'Le mot a bien été reinitialiser a 123456 !');
                return $this->redirectToRoute('list_utilisateur');
            } else {
                $this->addFlash('error' , 'Le mot de passe ne correspond pas !');
                return $this->redirectToRoute('app_logout');
            }
        }

        return $this->render('personnel/gestion/password_reset.html.twig' , [
            'personnels' => $utilisateur
        ]);
    }

}

