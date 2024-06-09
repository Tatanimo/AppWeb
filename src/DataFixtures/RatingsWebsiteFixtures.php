<?php

namespace App\DataFixtures;

use App\Entity\RatingsWebsite;
use App\Repository\ProfessionalsRepository;
use App\Repository\RatingsWebsiteRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RatingsWebsiteFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UsersRepository $usersRepository, private RatingsWebsiteRepository $ratingsWebsiteRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $this->usersRepository->findAll();

        foreach ($users as $user) {
            $randSend = rand(0, 1);
            
            if (boolval($randSend)) {
                $rating = new RatingsWebsite();
                $randomComment = rand(0,1);
                $rating->setUser($user)->setRating(rand(1,5))->setComment(boolval($randomComment) ? $faker->sentence() : null);
                $manager->persist($rating);
            }
        }
            
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
        ];
    }
}
