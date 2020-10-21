<?php


namespace App\Listenner\Authentification;


use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

/**
 * Class LogoutListenners
 * @package App\Listenner\Authentification
 * @author jaures kano <ruddyjaures@mail.com>
 */
class LogoutListenners
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
     * @param LogoutEvent $event
     */
    public function onSymfonyComponentSecurityHttpEventLogoutEvent(LogoutEvent   $event ){
        $user = $event->getToken()->getUser();
        if($user != 'anon.'){
            $user->setIsConnected(false );
            $user->setLastDeconnexion(new DateTime());
            $this->em->persist($user);
            $this->em->flush();
        }

    }

}