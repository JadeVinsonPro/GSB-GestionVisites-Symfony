<?php


namespace App\Tests\Entity;

use App\Entity\Famille;
use PHPUnit\Framework\TestCase;

class FamilleTest extends TestCase
{
    public function testGetSetLibelle()
    {
        $famille = new Famille();
        $libelle = 'Famille de test';

        $famille->setLibelle($libelle);

        $this->assertEquals($libelle, $famille->getLibelle());
    }

    public function testToString()
    {
        $famille = new Famille();
        $libelle = 'Famille de test';

        $famille->setLibelle($libelle);

        $this->assertEquals($libelle, (string)$famille);
    }
}

