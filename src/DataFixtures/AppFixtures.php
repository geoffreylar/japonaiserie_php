<?php

namespace App\DataFixtures;

use App\Entity\User;
//use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $User = new User();
        $User->setUsername('demo');
        $User->setPassword($this->encoder->encodePassword($User,'demo'));
        $User->setRoles(['ROLE_ADMIN']);
        $manager->persist($User);

        $manager->flush();

        $faker = Factory::create('fr_FR');
        for($i=0; $i<30; $i++)
        {
            $Produit = new Produit();
            $Produit->settitre($faker->words(2,true));
            $Produit->setprix($faker->numberBetween(1,100000));
            $Produit->setdescription($faker->sentence(5,true));

            $manager->persist($Produit);
        }

        $manager->flush();
    }
}
