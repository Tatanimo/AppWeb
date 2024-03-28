<?php

namespace App\DataFixtures;

use App\Entity\CompaniesAddresses;
use App\Repository\CitiesRepository;
use App\Repository\CompaniesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompaniesAddressesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private CompaniesRepository $companiesRepository, private CitiesRepository $citiesRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $companies = $this->companiesRepository->findAll();
        $faker = Factory::create('fr_FR');

        foreach ($companies as $companie) {
            $randCities = rand(1, 4);
            for ($i=1; $i <= $randCities ; $i++) { 
                $address = new CompaniesAddresses();

                $id = rand(1, 35853);
                $cities = $this->citiesRepository->findOneBy(['id' => $id]);
    
                $address->setAddress($faker->address())->setCities($cities)->setCompanies($companie);
                
                $manager->persist($address);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompaniesFixtures::class
        ];
    }
}
