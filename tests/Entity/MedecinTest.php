<?php


namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Medecin;
use App\Entity\Rapport;
use Symfony\Component\Validator\Validation;

class MedecinTest extends KernelTestCase
{
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();

        // Initialiser le validateur Symfony
        $this->validator = self::bootKernel()->getContainer()->get('validator');
    }

    public function testCreateMedecin()
    {
        $medecin = new Medecin();
        $medecin->setNom('Nom du médecin');
        $medecin->setPrenom('Prénom du médecin');
        $medecin->setAdresse('Adresse du médecin');
        $medecin->setTel('0123456789');
        $medecin->setDepartement(123);

        $this->assertInstanceOf(Medecin::class, $medecin);
        $this->assertEquals('Nom du médecin', $medecin->getNom());
        $this->assertEquals('Prénom du médecin', $medecin->getPrenom());
        $this->assertEquals('Adresse du médecin', $medecin->getAdresse());
        $this->assertEquals('0123456789', $medecin->getTel());
        $this->assertEquals(123, $medecin->getDepartement());
    }

    public function testAddAndRemoveRapport()
    {
        $medecin = new Medecin();
        $rapport1 = new Rapport();
        $rapport2 = new Rapport();

        $medecin->addRapport($rapport1);
        $medecin->addRapport($rapport2);

        $this->assertCount(2, $medecin->getRapports());

        $medecin->removeRapport($rapport1);

        $this->assertCount(1, $medecin->getRapports());
        $this->assertTrue($medecin->getRapports()->contains($rapport2));
    }

    public function testToStringMethod()
    {
        $medecin = new Medecin();
        $medecin->setNom('Nom du médecin');
        $medecin->setPrenom('Prénom du médecin');

        $this->assertEquals('Nom du médecin Prénom du médecin', (string)$medecin);
    }

    public function testValidationConstraints()
    {
        $medecin = new Medecin();
        $medecin->setNom('Nom du médecin');
        $medecin->setPrenom('Prénom du médecin');
        $medecin->setAdresse('Adresse du médecin');
        $medecin->setTel('0123456789');
        $medecin->setDepartement(123);

        // Valider l'entité Medecin
        $errors = $this->validator->validate($medecin);

        $this->assertCount(0, $errors);

        // Tester une validation avec un numéro de téléphone invalide à cause d'une mauvaise longueur
        $medecin->setTel('12345');
        $errors = $this->validator->validate($medecin);

        $this->assertCount(1, $errors);
        $this->assertEquals('Erreur. Numéro de téléphone invalide', $errors[0]->getMessage());
    }
}
