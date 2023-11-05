<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompteRepository::class)]
class Compte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $numero = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull(message: 'Vous devez renseigner un type de compte')]
    private ?string $typeDeCompte = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\OneToMany(mappedBy: 'compteBeneficiaire', targetEntity: Virement::class, orphanRemoval: true)]
    private Collection $virementsRecu;

    #[ORM\OneToMany(mappedBy: 'compteEmetteur', targetEntity: Virement::class, orphanRemoval: true)]
    private Collection $virementsEnvoyes;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Operation::class, orphanRemoval: true)]
    private Collection $operations;

    #[ORM\ManyToOne(inversedBy: 'comptes')]
    #[Assert\NotNull(message: 'Vous devez renseigner un détenteur de compte')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $detenteur = null;

    public function __construct()
    {
        $this->montant = 0;
        $this->numero = rand(1000, 9999);
        $this->virementsRecu = new ArrayCollection();
        $this->virementsEnvoyes = new ArrayCollection();
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }


    public function getTypeDeCompte(): ?string
    {
        return $this->typeDeCompte;
    }

    public function setTypeDeCompte(string $typeDeCompte): static
    {
        $this->typeDeCompte = $typeDeCompte;

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

    /**
     * @return Collection<int, Virement>
     */
    public function getVirementsRecu(): Collection
    {
        return $this->virementsRecu;
    }

    public function addVirementRecu(Virement $virement): static
    {
        if (!$this->virementsRecu->contains($virement)) {
            $this->virementsRecu->add($virement);
            $virement->setCompteBeneficiaire($this);
        }

        return $this;
    }

    public function removeVirementsRecu(Virement $virement): static
    {
        if ($this->virementsRecu->removeElement($virement)) {
            // set the owning side to null (unless already changed)
            if ($virement->getCompteBeneficiaire() === $this) {
                $virement->setCompteBeneficiaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Virement>
     */
    public function getVirementsEnvoyes(): Collection
    {
        return $this->virementsEnvoyes;
    }

    public function addVirementsEnvoye(Virement $virementsEnvoye): static
    {
        if (!$this->virementsEnvoyes->contains($virementsEnvoye)) {
            $this->virementsEnvoyes->add($virementsEnvoye);
            $virementsEnvoye->setCompteEmetteur($this);
        }

        return $this;
    }

    public function removeVirementsEnvoye(Virement $virementsEnvoye): static
    {
        if ($this->virementsEnvoyes->removeElement($virementsEnvoye)) {
            // set the owning side to null (unless already changed)
            if ($virementsEnvoye->getCompteEmetteur() === $this) {
                $virementsEnvoye->setCompteEmetteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): static
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
            $operation->setAuteur($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getAuteur() === $this) {
                $operation->setAuteur(null);
            }
        }

        return $this;
    }

    public function getDetenteur(): ?User
    {
        return $this->detenteur;
    }

    public function setDetenteur(?User $detenteur): static
    {
        $this->detenteur = $detenteur;

        return $this;
    }
}
