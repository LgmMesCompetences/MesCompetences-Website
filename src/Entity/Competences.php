<?php

namespace App\Entity;

use App\Repository\CompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CompetencesRepository::class)
 */
#[ApiResource()]
class Competences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    #[Assert\NotBlank]

    private $libelle;


    /**
     * @ORM\ManyToOne(targetEntity=Competences::class, inversedBy="competences")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Competences::class, mappedBy="parent")
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Posseder::class, mappedBy="competence")
     */
    private $posseders;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->posseders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }


    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(self $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->setParent($this);
        }

        return $this;
    }

    public function removeCompetence(self $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getParent() === $this) {
                $competence->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Posseder[]
     */
    public function getPosseders(): Collection
    {
        return $this->posseders;
    }

    public function addPosseder(Posseder $posseder): self
    {
        if (!$this->posseders->contains($posseder)) {
            $this->posseders[] = $posseder;
            $posseder->addCompetence($this);
        }

        return $this;
    }

    public function removePosseder(Posseder $posseder): self
    {
        if ($this->posseders->removeElement($posseder)) {
            $posseder->removeCompetence($this);
        }

        return $this;
    }
}
