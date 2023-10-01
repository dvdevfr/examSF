<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create('fr_FR');

        $admin = new Admin();
        $admin
            ->setEmail("rh@hb.com")
            //** azerty123 */
            ->setPassword('$2y$13$Zspr6LJZv5PGxJbyygwocOxKlgHQUo4KqTj.OR8zIKXrE.OR6A/aa');
        $manager->persist($admin);
        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setPassword($faker->password(6, 20))
                ->setProfilePicture($faker->imageUrl())
                ->setSector($faker->randomElement(User::POSSIBLE_SECTORS))
                ->setContractType($faker->randomElement(User::POSSIBLE_CONTRACT_TYPES));
            if ($user->getContractType() !== "CDI") {
                $user->setContractExpirationDate(new DateTime($faker->date()));
            }
            $manager->persist($user);
        }
        $manager->flush();
    }
}
