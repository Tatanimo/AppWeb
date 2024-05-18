<?php

namespace App\DataFixtures;

use App\Entity\Appointments;
use App\Entity\Schedules;
use App\Repository\AnimalsRepository;
use App\Repository\ProfessionalsRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SchedulesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private AnimalsRepository $animalsRepository, private ProfessionalsRepository $professionalsRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $professionals = $this->professionalsRepository->findAll();

        foreach ($professionals as $professional) {
            for ($i=0; $i < rand(0, 30); $i++) { 
                $schedule = new Schedules();
                $start = $faker->dateTimeBetween('now', '+2 months');
                $schedule->setProfessional($professional)->setUnavailability($start);
    
                $manager->persist($schedule);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProfessionalsFixtures::class
        ];
    }
}
