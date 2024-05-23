<?php

namespace App\DataFixtures;

use App\Entity\Appointments;
use App\Repository\AnimalsRepository;
use App\Repository\ProfessionalsRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppointmentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private AnimalsRepository $animalsRepository, private ProfessionalsRepository $professionalsRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=1; $i < 50 ; $i++) { 
            $appointment = new Appointments();
            $animal = $this->animalsRepository->randomAnimal();
            $startDate = $faker->dateTimeThisDecade();
            $appointment->setStartDate($startDate)->setEndDate($faker->dateTimeBetween($startDate))->setAnimal($animal)->setProfessional($this->professionalsRepository->randomProfessional());
            $manager->persist($appointment);            
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AnimalsFixtures::class,
            ProfessionalsFixtures::class
        ];
    }
}
