<?php


namespace App\Listenner\Authentification;


use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Class LoginListenner
 * @package App\Listenner\Authentification
 * @author jaures kano <ruddyjaures@mail.com>
 */
class LoginListenners
{
    private $em;

    /**
     * LoginListenners constructor.
     * @param $em
     */
    public function __construct( EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractivelogin(InteractiveLoginEvent  $event ){
        $user = $event->getAuthenticationToken()->getUser();
        $user->setIsConnected(true);
        $user->setLastConnexion(new DateTime());
        $this->em->persist($user);
        $this->em->flush();
    }
}
