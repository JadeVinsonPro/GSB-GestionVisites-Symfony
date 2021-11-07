<?php

namespace App\Entity;

use App\Repository\OffrirRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffrirRepository::class)
 */
class Offrir
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Medicament::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $medicament;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Rapport::class, inversedBy="offrirs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rapport;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;


    public function getMedicament(): ?Medicament
    {
        return $this->medicament;
    }

    public function setMedicament(?Medicament $medicament): self
    {
        $this->medicament = $medicament;

        return $this;
    }

    public function getRapport(): ?Rapport
    {
        return $this->rapport;
    }

    public function setRapport(?Rapport $rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
