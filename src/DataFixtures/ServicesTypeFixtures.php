<?php

namespace App\DataFixtures;

use App\Entity\ServicesType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServicesTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $services = ['toiletteur', 'vétérinaire', 'petsitter'];

        foreach ($services as $service) {
            $servicesTypes = new ServicesType();
            $servicesTypes->setType($service);
            $manager->persist($servicesTypes);
        }
        
        $manager->flush();
    }
}
