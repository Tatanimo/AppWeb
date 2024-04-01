<?php

namespace App\DataFixtures;

use App\Entity\Commentaries;
use App\Repository\PostsRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentariesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private PostsRepository $postsRepository, private UsersRepository $usersRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $posts = $this->postsRepository->findAll();

        foreach ($posts as $post) {
            $randCommentaries = rand(0, 10);
            for ($i=1; $i <= $randCommentaries ; $i++) { 
                $commentary = new Commentaries();
                $publicationDate = $faker->dateTimeThisDecade();
                $randParagraphs = rand(1, 4);
                
                $commentary->setContent($faker->paragraphs($randParagraphs, true))->setPublicationDate($publicationDate)->setModificationDate($faker->dateTimeBetween($publicationDate))->setFkUser($this->usersRepository->randomUser())->setPosts($post);

                $manager->persist($commentary);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
            PostsFixtures::class
        ];
    }
}
