<?php

namespace App\DataFixtures;

use App\Entity\Messages;
use App\Repository\RoomsRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MessagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private RoomsRepository $roomsRepository, private UsersRepository $usersRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $rooms = $this->roomsRepository->findAll();

        foreach ($rooms as $room) {
            $randMessages = rand(1, 15);
            $reference = explode('-', $room->getReference());
            $user_1 = $this->usersRepository->findOneBy(['id' => $reference[0]]);
            $user_2 = $this->usersRepository->findOneBy(['id' => $reference[1]]);
            $arrayUsers = [$user_1, $user_2];
            for ($i=1; $i <= $randMessages ; $i++) {
                $randomAuthor = rand(0, 1); 
                $message = new Messages();
                $message->setRooms($room);
                $message->setAuthor($arrayUsers[$randomAuthor]);
                $message->setContent($faker->sentences(asText:true));
                $message->setPublicationDate($faker->dateTimeThisYear());
                $message->setType("message");
                $manager->persist($message);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RoomsFixtures::class,
        ];
    }
}
