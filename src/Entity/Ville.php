<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Veuillez saisir le nom de la ville")]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Assert\NotBlank(message: "Veuillez saisir le code postal de votre ville")]
    #[Assert\Length(
        max: 5,
        maxMessage:"Un code postal doit faire {{ limit }} caractères maximum !"
    )]

    #[ORM\Column]
    private ?int $codePostal = null;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Lieu::class, cascade:['persist', 'remove'] )]
    private Collection $lieux;

    public function __construct()
    {
        $this->lieux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection<int, Lieu>
     */
    public function getLieux(): Collection
    {
        return $this->lieux;
    }

    public function addLieu(Lieu $lieu): self
    {
        if (!$this->lieux->contains($lieu)) {
            $this->lieux->add($lieu);
            $lieu->setVille($this);
        }

        return $this;
    }

    public function removeLieu(Lieu $lieu): self
    {
        if ($this->lieux->removeElement($lieu)) {
            // set the owning side to null (unless already changed)
            if ($lieu->getVille() === $this) {
                $lieu->setVille(null);
            }
        }

        return $this;
    }
}
