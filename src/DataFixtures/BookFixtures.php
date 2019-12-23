<?php


namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class BookFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $book = $this->createBook("La République", 1, 10, "PUF");
        $manager->persist($book);

        $book = $this->createBook("Le Banquet", 1, 13, "Hachette");
        $manager->persist($book);

        $book = $this->createBook("Three men in a boat", 2, 12, "Seuil");
        $manager->persist($book);

        $book = $this->createBook("Vernon Subutex", 3, 15, "Grasset");
        $manager->persist($book);

        $book = $this->createBook("Dune", 1, 8, "Hachette");
        $manager->persist($book);

        $manager->flush();
    }

    private function createBook($title, $author, $price, $publisher){
       $book = new Book();
       $book
           ->setTitle($title)
           ->addAuthor($this->getReference("author_$author"))
           ->setPrice($price)
           ->setPublisher($this->getReference("publisher_$publisher"));
       return $book;
    }


    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            PublisherFixtures::class,
            AuthorFixtures::class
        ];
    }
}