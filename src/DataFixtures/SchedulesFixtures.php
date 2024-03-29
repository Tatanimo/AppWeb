<?php

namespace App\DataFixtures;

use App\Entity\Schedules;
use App\Repository\AnimalsRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SchedulesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private AnimalsRepository $animalsRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=1; $i < 50 ; $i++) { 
            $schedules = new Schedules();
            $animal = $this->animalsRepository->randomAnimal();
            $startDate = $faker->dateTimeThisDecade();
            $schedules->setStartDate($startDate)->setEndDate($faker->dateTimeBetween($startDate))->setAnimals($animal)->setUsers($animal->getFkUser());
            $manager->persist($schedules);            
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AnimalsFixtures::class
        ];
    }
}
