<?php


namespace App\Controller\Personnels;

use App\Entity\Utilisateur;
use App\Form\Personnels\ImageType;
use App\Form\Personnels\PasswordResetType;
use App\Form\UtilisateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("account-managment")
 * Class GestionRolesController
 * @package App\Controller\Personnels
 * @author jaures kano <ruddyjaures@mail.com>
 */
class AccountManagmentController extends AbstractController
{
    /**
     * @Route("/guard/" , name="account_guard")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function index( Request $request , UserPasswordEncoderInterface $passwordEncoder ){

        if( $request->request->count() > 0 ){
            $password = $request->get('password');
            if ($passwordEncoder->isPasswordValid( $this->getUser() , $password)) {
                return $this->redirectToRoute('user_account_manager' , ['nom' => $this->getUser()->getNom() ] );
            } else {
                $this->addFlash('error' , 'Le mot de passe ne correspond pas !');
                return $this->redirectToRoute('account_guard');
            }
        }

        return $this->render('personnel/account_manager/guard.html.twig' , [
            'error' => ''
        ]);
    }

    /**
     * @Route("/{nom}/" , name="user_account_manager")
     * @param Utilisateur $utilisateur
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function indexGuard( Utilisateur $utilisateur , Request $request ,
                                UserPasswordEncoderInterface $passwordEncoder){
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm( UtilisateurType::class , $utilisateur );
        $form->handleRequest($request);
        if( $form->isSubmitted() and $form->isValid() ){
            $em->persist($utilisateur);
            $em->flush();
            $this->addFlash('success' , 'Les modifications ont bien été apporter !');
            return $this->redirectToRoute('user_account_manager' , ['nom' => $this->getUser()->getNom()]);
        }

        $formPassword = $this->createForm( PasswordResetType::class );
        $formPassword->handleRequest($request);
        if( $formPassword->isSubmitted() and $formPassword->isValid() ){
            $oldPassword = $formPassword['oldPassword']->getData();

            if ($passwordEncoder->isPasswordValid( $this->getUser() , $oldPassword)) {
                $newPassword = $formPassword['newPassword']->getData();
                $confirmPassword = $formPassword['confirmPassword']->getData();
                if ( $newPassword == $confirmPassword ){
                    $utilisateur->setPassword(
                        $passwordEncoder->encodePassword( $utilisateur ,
                            $newPassword ) );
                    $em->persist($utilisateur);
                    $em->flush();

                    $this->addFlash('success' , 'Le mot de passe a bien été changer !');
                    return $this->redirectToRoute('app_logout');
                }else{
                    $this->addFlash('error' ,
                        'La nouveau mot de passe ne coincide pas avec la confirmation veillez reesayer s\'il vous plait !');
                }
            } else {
                $this->addFlash('error' , 'L\'ancien mot de passe ne correspond pas !');
            }

            return $this->redirectToRoute('user_account_manager' , ['nom' => $this->getUser()->getNom()]);
        }

        $formImage = $this->createForm( ImageType::class , $utilisateur);
        $formImage->handleRequest($request);
        if( $formImage->isSubmitted() and $formImage->isValid() ){
            $em->persist($utilisateur);
            $em->flush();

            $this->addFlash('success' , 'L\'image à bien été changer !');
            return $this->redirectToRoute('user_account_manager' , ['nom' => $this->getUser()->getNom()]);
        }

        return $this->render('personnel/account_manager/index.html.twig' , [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
            'formPassword' => $formPassword->createView(),
            'formImage' => $formImage->createView(),
        ]);
    }

}

