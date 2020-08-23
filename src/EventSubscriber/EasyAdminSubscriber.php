<?php

      //      __________________________________________________________________________________
      //                                                                     N A M E S P A C E
      //      __________________________________________________________________________________
      namespace App\EventSubscriber;

      //      __________________________________________________________________________________
      //                                                                                U S E
      //      __________________________________________________________________________________
      use App\Entity\Image;
      use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
      use Symfony\Component\EventDispatcher\EventSubscriberInterface;
      use Symfony\Component\EventDispatcher\GenericEvent;
      use Symfony\Component\Security\Core\Security;


//      __________________________________________________________________________________
//                                                                             C L A S S
//      __________________________________________________________________________________
      class EasyAdminSubscriber implements EventSubscriberInterface
      {
            //      -               -               -              C O N S T R U C T O R               -               -               -
            public function __construct(Security $security)
            {
                  $this->security = $security;
            }     //    constructor

            //      -               -               -              getter SUBSCRIBED EVENTS               -               -               -
            public static function getSubscribedEvents()
            {
                  return [
                        'easy_admin.pre_persist' => ['setUser'],
                  ];
            }     //    getSubscribedEvents

            //      -               -               -              getter USER               -               -               -
            public function setUser(GenericEvent $event)
            {
                  $entity = $event->getSubject();
                  if ( $entity instanceof Image) {
                        $entity->setUser($this->security->getUser() );
                  }
            }     //    getUser
      }     //    class EasyAdminSubscriber