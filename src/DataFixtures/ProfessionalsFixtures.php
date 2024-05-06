<?php

namespace App\DataFixtures;

use App\Entity\Professionals;
use App\Repository\CitiesRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProfessionalsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UsersRepository $usersRepository, private CitiesRepository $citiesRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $this->usersRepository->findAll();
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
                
                $criteriaList = [];
                for ($i=1; $i <= $randCriteria ; $i++) { 
                    $randEmoji = rand(0, count($emoji));
                    $criteria = [
                        "emoji" => $emoji[$randEmoji],
                        "content" => $faker->sentence()
                    ];
                    array_push($criteriaList, $criteria);
                }

                $professional->setAddress($faker->address())->setCity($cities)->setDescription($faker->paragraph($randPar, true))->setLiveIn($liveIn[$randLivIn])->setPrice($faker->randomNumber(3))->setUser($user)->setCriteria($criteriaList);

                $manager->persist($professional);
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
