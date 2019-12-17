<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Mime\Encoder\EncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthorFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AuthorFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $manager->persist($this->createAuthor("Arfi", "Fabrice", 1));
        $manager->persist($this->createAuthor("Israel", "Dan", 2));
        $manager->persist($this->createAuthor("Zola", "Emile", 3));


        $manager->flush();
    }

    private function createAuthor($name, $firstName, $order){
        $author = new Author();
        $author ->setName($name)->setFirstName($firstName)
                ->setPassword($this->encoder->encodePassword($author, '123' ))
                ->setEmail("$name@author.com");
        $this->addReference("author_$order", $author);
        return $author;
    }
}
