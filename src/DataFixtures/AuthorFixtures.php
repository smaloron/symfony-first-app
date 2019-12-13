<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createAuthor("Arfi", "Fabrice", 1));
        $manager->persist($this->createAuthor("Israel", "Dan", 2));
        $manager->persist($this->createAuthor("Zola", "Emile", 3));


        $manager->flush();
    }

    private function createAuthor($name, $firstName, $order){
        $author = new Author();
        $author->setName($name)->setFirstName($firstName);
        $this->addReference("author_$order", $author);
        return $author;
    }
}
