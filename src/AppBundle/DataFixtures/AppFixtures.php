<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 05.07.18
 * Time: 19:30
 */

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\BookTab;
use AppBundle\Entity\AuthorTab;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $name = (string)(mt_rand(10000, 20000));


        // create 20 Book's with 2 author's for everyone
        for ($i = 0; $i < 20; $i++) {
            $randYear = (string)(mt_rand(1000, 2000));
            $randIsbn = (string)(mt_rand(100, 999)).'-'.(string)(mt_rand(1, 9)).'-'
                .(string)(mt_rand(10000, 99999)).'-'
                .(string)(mt_rand(100, 999)).'-'
                .(string)(mt_rand(1, 9));
            $Book = new BookTab();
            $Book->setTitle('Book '.$i);
            $Book->setPubYear($randYear);
            $Book->setIsbn($randIsbn);
            $manager->persist($Book);
            for($j = 0; $j < 6; $j++){
                $Author = new AuthorTab();
                $name = (string)(mt_rand(10000, 20000));
                $Author->setFirstName('FIRST'.$name.$j);
                $Author->setLastName('LAST'.$name.$j);
                $Author->setMiddleName('MID'.$name.$j);
                $Author->setBook($Book);
                $manager->persist($Author);
            }
        }

        $manager->flush();
    }
}