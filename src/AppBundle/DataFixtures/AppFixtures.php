<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Client;
use AppBundle\Entity\Room;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture{
    // run php bin/console doctrine:fixtures:load
    public function load(ObjectManager $manager)
    {
        // create 20 clients! Bam!
        for ($i = 1; $i < 20; $i++) {
        $client = new Client();
        $client->setName('client '.$i);
        $client->setTitle('Mr');
        $client->setLastName('last_name'.$i);
        $client->setAddress('address_fake_adress'.$i);
        $client->setZipCode(mt_rand(10000, 99999));
        $client->setCity('city'.$i);
        $client->setState('state'.$i);
        $client->setEmail( 'email'.$i.'@gmail.com');


        $manager->persist($client);
            // create 20 roms! ta-dah!
        $room = new Room();
        $room->setName($i);
        $room->setFloor(mt_rand(0, 5));
        $room->setDescription('random description of room ');

        $manager->persist($room);

    }

        $manager->flush();
    }
}