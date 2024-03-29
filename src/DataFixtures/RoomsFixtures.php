<?php

namespace App\DataFixtures;

use App\Entity\Rooms;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RoomsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UsersRepository $usersRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i <= 5 ; $i++) { 
            $room = new Rooms();

            $user_1 = $this->usersRepository->randomUser()->getId();
            
            do {
                $user_2 = $this->usersRepository->randomUser()->getId();
            }
            while ($user_1 == $user_2);

            $reference = $user_1 < $user_2 ? $user_1.'-'.$user_2 : $user_2.'-'.$user_1;

            $room->setReference($reference);

            $manager->persist($room);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class
        ];
    }
}
