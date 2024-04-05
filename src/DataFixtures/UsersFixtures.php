<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Repository\CitiesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function __construct(private CitiesRepository $citiesRepository, private UserPasswordHasherInterface $hasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        //  Role_User
        for ($i = 0; $i < 100; $i++) {
            $user = new Users();

            $id = rand(1, 35853);
            $cities = $this->citiesRepository->findOneBy(['id' => $id]);

            $password = $faker->word();
            $hashedPassword = $this->hasher->hashPassword($user, $password);

            $user->setAddress($faker->address())->setBirthdate($faker->datetime())->setCities($cities)->setEmail($faker->email())->setFirstName($faker->firstName())->setLastName($faker->lastName())->setPhoneNumber($faker->e164PhoneNumber())->setRoles(['ROLE_USER'])->setPassword($hashedPassword)->setIban($faker->iban('FR'));

            $manager->persist($user);
        }

        // Role_Admin
        for ($i = 0; $i < 10; $i++) {
            $user = new Users();

            $id = rand(1, 35853);
            $cities = $this->citiesRepository->findOneBy(['id' => $id]);

            $password = $faker->word();
            $hashedPassword = $this->hasher->hashPassword($user, $password);

            $user->setAddress($faker->address())->setBirthdate($faker->datetime())->setCities($cities)->setEmail($faker->email())->setFirstName($faker->firstName())->setLastName($faker->lastName())->setPhoneNumber($faker->e164PhoneNumber())->setRoles(['ROLE_ADMIN'])->setPassword($hashedPassword)->setIban($faker->iban('FR'));

            $manager->persist($user);
        }

        $user = new Users();

        $id = rand(1, 35853);
        $cities = $this->citiesRepository->findOneBy(['id' => $id]);

        $password = "Admin12345&!";
        $hashedPassword = $this->hasher->hashPassword($user, $password);

        $user->setAddress($faker->address())->setBirthdate($faker->datetime())->setCities($cities)->setEmail("admin@admin.fr")->setFirstName($faker->firstName())->setLastName($faker->lastName())->setPhoneNumber($faker->e164PhoneNumber())->setRoles(['ROLE_ADMIN'])->setPassword($hashedPassword)->setIban($faker->iban('FR'));

        $manager->persist($user);

        $manager->flush();
    }
}
