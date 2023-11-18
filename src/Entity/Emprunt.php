<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Vous devez renseigner un montant à l\'emprunt')]
    #[Assert\GreaterThan(value: 499, message: "Le montant d'un emprunt ne peut pas être inférieure à 500€ ")]
    private ?float $montant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $echeance = null;

    #[ORM\Column]
    private ?float $annuite = null;

    #[ORM\ManyToOne(inversedBy: 'emprunts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $emprunteur = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "Le taux ne peut pas être nul... On aime le profit chez Y")]
    private ?float $taux = null;

    #[ORM\Column]
    private ?float $motantRembourse = null;

    public function __construct()
    {
        $this->motantRembourse = 0;
        $this->date = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getEcheance(): ?\DateTimeInterface
    {
        return $this->echeance;
    }

    public function setEcheance(\DateTimeInterface $echeance): static
    {
        $this->echeance = $echeance;

        return $this;
    }

    public function getAnnuite(): ?float
    {
        return $this->annuite;
    }

    public function setAnnuite(float $annuite): static
    {
        $this->annuite = $annuite;

        return $this;
    }

    public function getEmprunteur(): ?User
    {
        return $this->emprunteur;
    }

    public function setEmprunteur(?User $emprunteur): static
    {
        $this->emprunteur = $emprunteur;

        return $this;
    }

    public function getTaux(): ?float
    {
        return $this->taux;
    }

    public function setTaux(float $taux): static
    {
        $this->taux = $taux;

        return $this;
    }

    public function getMotantRembourse(): ?float
    {
        return $this->motantRembourse;
    }

    public function setMotantRembourse(float $motantRembourse): static
    {
        $this->motantRembourse = $motantRembourse;

        return $this;
    }
}
