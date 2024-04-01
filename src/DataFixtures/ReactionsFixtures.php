<?php

namespace App\DataFixtures;

use App\Entity\Reactions;
use App\Repository\CommentariesRepository;
use App\Repository\PostsRepository;
use App\Repository\ReactionsRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReactionsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private CommentariesRepository $commentariesRepository, private PostsRepository $postsRepository, private UsersRepository $usersRepository, private ReactionsRepository $reactionsRepository)
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $posts = $this->postsRepository->findLimit50();
        $commentaries = $this->commentariesRepository->findLimit50();
        $emoji = ['like','love','funny','angry','crying','success'];

        foreach ($posts as $post) {
            $randReact = rand(0, 5);

            for ($i=1; $i <= $randReact ; $i++) { 
                $reaction = new Reactions();
                $randEmoji = rand(0, count($emoji) - 1);
                
                do {
                    $user = $this->usersRepository->randomUser();
                } while ($this->reactionsRepository->findOneByUserAndPost($user, $post) != null);

                $reaction->setPosts($post)->setUsers($user)->setEmoji($emoji[$randEmoji]);

                $manager->persist($reaction);
                $manager->flush();
            }
        }

        foreach ($commentaries as $commentary) {
            $randReaction = rand(0, 5);

            for ($in=1; $in <= $randReaction ; $in++) { 
                $reaction = new Reactions();
                $randEmoji = rand(0, count($emoji) - 1);
                
                do {
                    $user = $this->usersRepository->randomUser();
                } while ($this->reactionsRepository->findOneByUserAndCommentary($user, $commentary) != null);

                $reaction->setCommentaries($commentary)->setUsers($user)->setEmoji($emoji[$randEmoji]);

                $manager->persist($reaction);
                $manager->flush();
            }
        }

    }

    public function getDependencies()
    {
        return [
            UsersFixtures::class,
            PostsFixtures::class,
            CommentariesFixtures::class
        ];
    }
}
