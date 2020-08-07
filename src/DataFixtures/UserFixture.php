<?php

//      __________________________________________________________________________________
//                                                                     N A M E S P A C E
//      __________________________________________________________________________________
namespace App\DataFixtures;


//      __________________________________________________________________________________
//                                                                                U S E
//      __________________________________________________________________________________
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


//      __________________________________________________________________________________
//                                                                             C L A S S
//      __________________________________________________________________________________

class UserFixture extends BaseFixture
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               P A S S W O R D   E N C O D E R               -               -               -
    private $passwordEncoder;


    //      __________________________________________________________________________________
    //                                                                        M E T H O D S
    //      __________________________________________________________________________________


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    //      -               -               -              loader DATA               -               -               -
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(1, 'main_users', function ($i) {
            $user = new User();
            $user->setEmail(sprintf('test@example.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'authenticate'));
            $user->setRoles([]);

            return $user;
        });

        $manager->flush();
    }
}