<?php

namespace App\Entity;

use App\Repository\MedicamentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicamentRepository::class)
 */
class Medicament
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomCommercial;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $familleId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $composition;

    /**
     * @ORM\Column(type="text")
     */
    private $effets;

    /**
     * @ORM\Column(type="text")
     */
    private $contreIndications;

    /**
     * @ORM\ManyToOne(targetEntity=Famille::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $famille;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNomCommercial(): ?string
    {
        return $this->nomCommercial;
    }

    public function setNomCommercial(string $nomCommercial): self
    {
        $this->nomCommercial = $nomCommercial;

        return $this;
    }

    public function getFamilleId(): ?string
    {
        return $this->familleId;
    }

    public function setFamilleId(string $familleId): self
    {
        $this->familleId = $familleId;

        return $this;
    }

    public function getComposition(): ?string
    {
        return $this->composition;
    }

    public function setComposition(string $composition): self
    {
        $this->composition = $composition;

        return $this;
    }

    public function getEffets(): ?string
    {
        return $this->effets;
    }

    public function setEffets(string $effets): self
    {
        $this->effets = $effets;

        return $this;
    }

    public function getContreIndications(): ?string
    {
        return $this->contreIndications;
    }

    public function setContreIndications(string $contreIndications): self
    {
        $this->contreIndications = $contreIndications;

        return $this;
    }

    public function getFamille(): ?Famille
    {
        return $this->famille;
    }

    public function setFamille(?Famille $famille): self
    {
        $this->famille = $famille;

        return $this;
    }

    public function __toString()
    {
        return $this->nomCommercial." ".$this->composition;
    }
}
