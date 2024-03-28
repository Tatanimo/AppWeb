<?php

namespace App\DataFixtures;

use App\Entity\Companies;
use App\Entity\CompaniesAddresses;
use App\Entity\ServicesType;
use App\Repository\ServicesTypeRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class CompaniesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private ServicesTypeRepository $servicesTypeRepository, private UsersRepository $usersRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($in=1; $in <= 10 ; $in++) { 
            $companies = new Companies();
            $companies->setName($faker->company());
            $randServices = rand(1, 3);

            for ($i=1; $i <= $randServices; $i++) { 
                $services = $this->servicesTypeRepository->findAll();
                $randomIndex = rand(0, count($services) - 1);
                $companies->addServicesType($services[$randomIndex]);
            }

            $randUsers = rand(1, 15);
            for ($ind=1; $ind <= $randUsers; $ind++) {
                $user = $this->usersRepository->randomUser();
                $companies->addUser($user);
            }

            $manager->persist($companies);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ServicesTypeFixtures::class,
            UsersFixtures::class
        ];
    }
}
