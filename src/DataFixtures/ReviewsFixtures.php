<?php

namespace App\DataFixtures;

use App\Entity\Reviews;
use App\Repository\ReviewsRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReviewsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UsersRepository $usersRepository, private ReviewsRepository $reviewsRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $this->usersRepository->findAll();

        foreach ($users as $user) {
            $randReceiver = rand(1, 5);
            
            for ($i=0; $i < $randReceiver; $i++) { 
                $review = new Reviews();

                $randomComment = rand(0,1);
                
                do {
                    $randomReceiver = $this->usersRepository->randomUser();
                } while (
                    $randomReceiver == $user || $this->reviewsRepository->findOneByReceiverAndSender($randomReceiver->getId(), $user->getId()) != null
                );

                $review->setFkUserReceiver($randomReceiver)->setFkUserSender($user)->setRating(rand(1,5))->setComment(boolval($randomComment) ? $faker->sentence() : null);
                
                $manager->persist($review);
                $manager->flush();
            }
        }

    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
        ];
    }
}
