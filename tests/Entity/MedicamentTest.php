<?php


namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Medicament;
use App\Entity\Famille;

class MedicamentTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        // Initialiser l'EntityManager de Doctrine
        $this->entityManager = self::bootKernel()->getContainer()->get('doctrine')->getManager();
    }

    public function testCreateFamille()
    {
        $famille = new Famille();
        $famille->setFamilleId('FAM');
        $famille->setNom('Famille de test');

        $this->assertInstanceOf(Famille::class, $famille);
        $this->assertEquals('Famille de test', $famille->getNom());
    }

    public function testCreateMedicament()
    {
        $medicament = new Medicament();
        $medicament->setNomCommercial('Medicament Test');
        $medicament->setFamilleId('FAM');

        $medicament->setComposition('Ingrédients du médicament');
        $medicament->setEffets('Effets du médicament');
        $medicament->setContreIndications('Contre-indications du médicament');

        $this->assertInstanceOf(Medicament::class, $medicament);
        $this->assertEquals('Medicament Test', $medicament->getNomCommercial());
        $this->assertEquals('FAM', $medicament->getFamilleId());
        $this->assertEquals('Ingrédients du médicament', $medicament->getComposition());
        $this->assertEquals('Effets du médicament', $medicament->getEffets());
        $this->assertEquals('Contre-indications du médicament', $medicament->getContreIndications());
    }

    public function testSetAndGetFamille()
    {
        $medicament = new Medicament();
        $famille = new Famille();
        $famille->setNom('Famille de test');

        $medicament->setFamille($famille);

        $this->assertInstanceOf(Famille::class, $medicament->getFamille());
        $this->assertEquals('Famille de test', $medicament->getFamille()->getNom());
    }

    public function testToStringMethod()
    {
        $medicament = new Medicament();
        $medicament->setNomCommercial('Medicament Test');
        $medicament->setComposition('Ingrédients du médicament');

        $this->assertEquals('Medicament Test Ingrédients du médicament', (string)$medicament);
    }

    public function testValidationConstraints()
    {
        $medicament = new Medicament();
        $medicament->setNomCommercial('Medicament Test');
        $medicament->setFamilleId('FAM');
        $medicament->setComposition('Ingrédients du médicament');
        $medicament->setEffets('Effets du médicament');
        $medicament->setContreIndications('Contre-indications du médicament');

        // Valider l'entité Medicament
        $errors = $this->entityManager->validate($medicament);

        $this->assertCount(0, $errors);

        // Tester une validation avec une famille vide
        $medicament->setFamille(null);
        $errors = $this->entityManager->validate($medicament);

        $this->assertCount(1, $errors);
        $this->assertEquals('This value should not be blank.', $errors[0]->getMessage());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Nettoyer l'EntityManager après les tests
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
