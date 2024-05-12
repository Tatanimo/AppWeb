<?php

namespace App\DataFixtures;

use App\Entity\Reviews;
use App\Repository\ProfessionalsRepository;
use App\Repository\ReviewsRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReviewsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UsersRepository $usersRepository, private ProfessionalsRepository $professionalsRepository, private ReviewsRepository $reviewsRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $this->usersRepository->findAll();
        $professionals = $this->professionalsRepository->findAll();

        foreach ($users as $user) {
            $randReceiver = rand(0, 5);
            
            for ($i=0; $i < $randReceiver; $i++) { 
                $review = new Reviews();

                $randomComment = rand(0,1);
                
                do {
                    $professional = $this->professionalsRepository->randomProfessional();
                } while (
                    $professional->getUser() == $user || $this->reviewsRepository->findOneByUserAndProfessional($user->getId(), $professional->getId(), true) != null
                );

                $review->setUser($user)->setProfessional($professional)->setProfessionalReceiver(true)->setRating(rand(1,5))->setComment(boolval($randomComment) ? $faker->sentence() : null);
                
                $manager->persist($review);
                $manager->flush();
            }
        }

        foreach ($professionals as $professional) {
            $randReceiver = rand(0, 5);
            
            for ($i=0; $i < $randReceiver; $i++) { 
                $review = new Reviews();

                $randomComment = rand(0,1);
                
                do {
                    $user = $this->usersRepository->randomUser();
                } while (
                    $professional->getUser() == $user || $this->reviewsRepository->findOneByUserAndProfessional($user->getId(), $professional->getId(), false) != null
                );

                $review->setUser($user)->setProfessional($professional)->setProfessionalReceiver(false)->setRating(rand(1,5))->setComment(boolval($randomComment) ? $faker->sentence() : null);
                
                $manager->persist($review);
                $manager->flush();
            }
        }

    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
            ProfessionalsFixtures::class
        ];
    }
}
