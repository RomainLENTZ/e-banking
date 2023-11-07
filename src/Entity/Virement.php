<?php

namespace App\Entity;

use App\Repository\VirementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VirementRepository::class)]
class Virement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'virementsRecu')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compte $compteBeneficiaire = null;

    #[ORM\ManyToOne(inversedBy: 'virementsEnvoyes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compte $compteEmetteur = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Vous devez renseigner un montant')]
    #[Assert\Positive(message: 'Le montant ne peux pas être négatif')]
    private ?float $montant = null;


    public function __construct()
    {
        $this->date = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getCompteBeneficiaire(): ?Compte
    {
        return $this->compteBeneficiaire;
    }

    public function setCompteBeneficiaire(?Compte $compteBeneficiaire): static
    {
        $this->compteBeneficiaire = $compteBeneficiaire;

        return $this;
    }

    public function getCompteEmetteur(): ?Compte
    {
        return $this->compteEmetteur;
    }

    public function setCompteEmetteur(?Compte $compteEmetteur): static
    {
        $this->compteEmetteur = $compteEmetteur;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }
}
