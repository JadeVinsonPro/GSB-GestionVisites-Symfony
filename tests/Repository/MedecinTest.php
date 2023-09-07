<?php
// tests/Repository/MedecinRepositoryTest.php

namespace App\Tests\Repository;

use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MedecinRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $repository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->repository = $this->entityManager->getRepository(Medecin::class);
    }

    public function testFindMedecinByNom()
    {
        // Créez un médecin de test pour l'ajouter à la base de données
        $medecin = new Medecin();
        $medecin->setNom('Test');
        $this->entityManager->persist($medecin);
        $this->entityManager->flush();

        // Utilisez la méthode de recherche par nom
        $medecins = $this->repository->findMedecinByNom('Test');

        // Vérifiez que le médecin de test est présent dans les résultats
        $this->assertNotEmpty($medecins);
        $this->assertEquals('Test', $medecins[0]->getNom());
    }
}
