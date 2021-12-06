<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
#[ApiResource(
    denormalizationContext: [
        'groups' => ['comp:write']
    ],
    normalizationContext: [
        'groups' => ['comp:read']
    ],
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_ADMIN')"],
    ],
    itemOperations: [
        "get",
        "patch" => ["security" => "is_granted('ROLE_ADMIN')"],
        "delete" => ["security" => "is_granted('ROLE_ADMIN')"],
    ],
)]
#[ApiFilter(NumericFilter::class, properties: ["level"=> "exact"])]
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["comp:read", "poss:read"])]
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    #[Assert\NotBlank]
    #[Groups(["com:write", "comp:read", "poss:read"])]
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="Competence")
     */
    #[Groups(["com:write", "comp:read", "poss:read"])]
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Competence::class, mappedBy="parent")
     */
    private $Competence;


    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(["com:write", "comp:read", "poss:read"])]
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class)
     */
    #[Groups(["com:write", "comp:read", "poss:read"])]
    private $mainComp;

    /**
     * @ORM\OneToMany(targetEntity=Posseder::class, mappedBy="competence")
     */
    private $posseders;

    public function __construct()
    {
        $this->Competence = new ArrayCollection();
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
    public function getCompetence(): Collection
    {
        return $this->Competence;
    }

    public function addCompetence(self $competence): self
    {
        if (!$this->Competence->contains($competence)) {
            $this->Competence[] = $competence;
            $competence->setParent($this);
        }

        return $this;
    }

    public function removeCompetence(self $competence): self
    {
        if ($this->Competence->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getParent() === $this) {
                $competence->setParent(null);
            }
        }

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getMainComp(): ?Competence
    {
        return $this->mainComp;
    }

    public function setMainComp(?Competence $mainComp): self
    {
        $this->mainComp = $mainComp;

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
            $posseder->setCompetence($this);
        }

        return $this;
    }

    public function removePosseder(Posseder $posseder): self
    {
        if ($this->posseders->removeElement($posseder)) {
            // set the owning side to null (unless already changed)
            if ($posseder->getCompetence() === $this) {
                $posseder->setCompetence(null);
            }
        }

        return $this;
    }
}
