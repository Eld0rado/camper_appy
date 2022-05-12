<?php

namespace App\Entity;

use App\Repository\CampingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampingRepository::class)]
class Camping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomCamping;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nbBungalow;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $nbTentes;

    #[ORM\Column(type: 'string', length: 255)]
    private $secteur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $information;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCamping(): ?string
    {
        return $this->nomCamping;
    }

    public function setNomCamping(string $nomCamping): self
    {
        $this->nomCamping = $nomCamping;

        return $this;
    }

    public function getNbBungalow(): ?int
    {
        return $this->nbBungalow;
    }

    public function setNbBungalow(?int $nbBungalow): self
    {
        $this->nbBungalow = $nbBungalow;

        return $this;
    }

    public function getNbTentes(): ?int
    {
        return $this->nbTentes;
    }

    public function setNbTentes(?int $nbTentes): self
    {
        $this->nbTentes = $nbTentes;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(?string $information): self
    {
        $this->information = $information;

        return $this;
    }
}
