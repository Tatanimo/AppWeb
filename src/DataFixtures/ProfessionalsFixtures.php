<?php

namespace App\DataFixtures;

use App\Entity\CategoryAnimals;
use App\Entity\Professionals;
use App\Entity\ServicesType;
use App\Repository\CategoryAnimalsRepository;
use App\Repository\CitiesRepository;
use App\Repository\ServicesTypeRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProfessionalsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UsersRepository $usersRepository, private CitiesRepository $citiesRepository, private ServicesTypeRepository $servicesTypeRepository, private CategoryAnimalsRepository $categoryAnimalsRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $this->usersRepository->findAll();
        $services = $this->servicesTypeRepository->findAll();
        $liveIn = ["house", "appartment"];
        $emoji = ["non-smoker", "smoker", "dog", "cat", "ban", "couch", "timer"];

        foreach ($users as $user) {
            $randomProfessionals = boolval(rand(0, 1));
            if ($randomProfessionals) {
                $professional = new Professionals();

                $id = rand(1, 35853);
                $cities = $this->citiesRepository->findOneBy(['id' => $id]);

                $randPar = rand(1, 5);
                $randLivIn = rand(0, 1);
                $randCriteria = rand(1, 5);
                $randomServices = rand(0, count($services) - 1);
                
                $criteriaList = [];
                for ($i=1; $i <= $randCriteria ; $i++) { 
                    $randEmoji = rand(0, count($emoji) - 1);
                    $criteria = [
                        "emoji" => $emoji[$randEmoji],
                        "content" => $faker->sentence()
                    ];
                    array_push($criteriaList, $criteria);
                }

                $professional->setAddress($faker->address())->setCity($cities)->setDescription($faker->paragraph($randPar, true))->setLiveIn($liveIn[$randLivIn])->setPrice($faker->randomNumber(3))->setUser($user)->setCriteria($criteriaList)->setService($services[$randomServices]);

                $categoriesAnimals = $this->categoryAnimalsRepository->findAll();
                shuffle($categoriesAnimals);

                for ($i=0; $i < rand(1, count($categoriesAnimals)) ; $i++) { 
                    $in = array_rand($categoriesAnimals);
                    $professional->addAllowedCategory($categoriesAnimals[$in]);
                    unset($categoriesAnimals[$in]);
                }

                $manager->persist($professional);
                $manager->flush();
            }
        }

    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
            ServicesTypeFixtures::class,
        ];
    }
}
