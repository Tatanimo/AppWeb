<?php

namespace App\DataFixtures;

use App\Entity\Animals;
use App\Repository\CategoryAnimalsRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Console\Output\ConsoleOutput;

class AnimalsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UsersRepository $usersRepository, private CategoryAnimalsRepository $categoryAnimalsRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        $users = $this->usersRepository->findAllByRole('ROLE_USER');

        foreach ($users as $user) {
            $randAnimals = rand(0, 4);
            for ($i=1; $i <= $randAnimals ; $i++) { 
                $animals = new Animals();
                $randDeath = rand(0, 1);
                $randDescription = rand(0, 1);

                $category = $this->categoryAnimalsRepository->randomCategory();

                $animals->setName($faker->firstName())->setRace($faker->word())->setWeight($faker->randomNumber(3, false))->setBirthdate($faker->dateTimeThisDecade())->setDeath(boolval($randDeath))->setDescription(boolval($randDescription) ? $faker->paragraphs(3, true) : null)->setFkUser($user)->setFkCategory($category);

                $manager->persist($animals);
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
