<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ArticlesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UsersRepository $usersRepository)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 25; $i++) {
            $article = new Articles();
            $slugger = new AsciiSlugger();

            // Nombre de lignes max
            $randPara = rand(1, 10);
            $randDesc = rand(1, 3);
            $randWords = rand(1, 5);
            $randBool = rand(0, 1);
            $randState = rand(0, 1);

            $publicationDate = $faker->dateTimeBetween('-2 years', 'now');
            $title = $faker->word();

            $users = $this->usersRepository->findAllByRole('ROLE_ADMIN');

            $article->setDescription($faker->paragraph($randDesc, true))->setContent($faker->paragraph($randPara, true))->setKeyword($faker->words($randWords))->setPublicationDate($publicationDate)->setModificationDate(boolval($randBool) ? $faker->dateTimeBetween($publicationDate, '+1 week') : null)->setSlug($slugger->slug($title))->setTitle($title)->setState(boolval($randState))->setUsers($users[rand(0, count($users) - 1)]);

            $manager->persist($article);
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
