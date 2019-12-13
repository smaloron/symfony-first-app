<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $numberOfArticles = 100;

        for($i = 1; $i <= $numberOfArticles; $i ++){
            $article = $this->getReference("article_$i");

            for($k=0; $k < mt_rand(0, 10); $k++){
                $comment = new Comment();
                $comment->setArticle($article)
                        ->setAuthor($faker->email)
                        ->setCommentText($faker->realText(mt_rand(50, 500)))
                        ->setCreatedAt($faker->dateTimeThisDecade);
                $manager->persist($comment);

            }
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            ArticleFixtures::class
        ];
    }
}
/*
Composer require validator
composer require security-csrf
*/