<?php

namespace App\DataFixtures;

use App\Entity\Creature;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreaturesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $creature = new Creature();
        $creature->setName('Dragon');
        $creature->setDescription('un dragon magnifique');
        $creature->setImages('dragon.jpg');
        $manager->persist($creature);

        $creature = new Creature();
        $creature->setName('Gobelin');
        $creature->setDescription('un gobelin pas très sympathique');
        $creature->setImages('gobelins.png');
        $manager->persist($creature);

        $manager->flush();
    }
}
