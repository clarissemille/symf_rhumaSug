<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\CommandeProduit;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture 
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        
        $this->encoder = $userPasswordHasherInterface; 
    }   

    public function load (ObjectManager $manager): void
    {
        $categories=[];
        for($i = 1; $i <= 5; $i ++){
            $categorie = new Categorie();
            $categorie->setNom("Categorie" . $i);
            $manager->persist($categorie);
            $categories[] = $categorie;

        }
        $produits= [];
        for($j = 1; $j <= 20; $j++){
            $produit = new Produit();
            $produit->setCategorie($categories[random_int(0, count($categories) -1)]);
            $produit->setDescription("Lorem ipsum dolor sit amet consectetur");
            $produit->setNom("Produit" . "" . $j);
            $produit->setImg("produit1.avif");
            $produit->setPrix($j + ($j/10));
            $manager->persist($produit);
            $produits[]= $produit;
        }

        $toto = new User();
        $toto->setNom("Toto");
        $toto->setEmail("toto@toto.fr");
        $hashedPassword = $this->encoder->hashPassword($toto, "toto");
        $toto->setPassword($hashedPassword);
        $manager->persist($toto);

        $commande = new Commande();
        $commande->setDate(new \DateTime());
        $commande->setEtat(0);
        $commande->setUser($toto);
        $manager->persist($commande);

        $cp1 = new CommandeProduit();
        $cp1->setCommande($commande);
        $cp1->setProduit($produits[0]);
        $cp1->setPrixVente($produits[0]->getPrix());
        $cp1->setQuantite(2);
        $manager->persist($cp1);

        $cp2 = new CommandeProduit();
        $cp2->setCommande($commande);
        $cp2->setProduit($produits[1]);
        $cp2->setPrixVente($produits[1]->getPrix());
        $cp2->setQuantite(3);
        $manager->persist($cp2);


   
        $manager->flush();
    }
}

            // $categorie = new Categorie();
            // $categorie->setNom('Categorie 1');
            // $categorie2 = new Categorie();
            // $categorie2->setNom('Categorie 2');
    
            // $manager->persist($categorie);
            // $manager->persist($categorie2);
            // $categories = ["Boissons", "Surgelés", "Produits frais", "Épicerie"];
    
            // foreach ($categories as $cat){
            //     $categorie = new Categorie();
            //     $categorie->setNom($cat);
            //     $manager->persist($categorie);
            // }