<?php

namespace App\DataFixtures;

use App\Entity\Posts;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostsFixtures extends Fixture
{
    public function __construct(private UsersRepository $usersRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        $users = $this->usersRepository->findAllByRole('ROLE_USER');

        foreach ($users as $user) {
            $randPosts = rand(0, 4);
            for ($i=1; $i <= $randPosts ; $i++) { 
                $post = new Posts();
                $randModification = rand(0, 1);
                $randParagraph = rand(1,5);
                $randWords = rand(1, 5);
                $randState = rand(0, 1);

                $publicationDate = $faker->dateTimeThisDecade();

                $post->setContent($faker->paragraphs($randParagraph, true))->setPublicationDate($publicationDate)->setModificationDate(boolval($randModification) ?$faker->dateTimeInInterval($publicationDate, '+1 month') : null)->setKeyword($faker->words($randWords))->setState(boolval($randState))->setFkUser($user);

                $manager->persist($post);
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
