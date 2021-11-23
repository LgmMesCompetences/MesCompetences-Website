<?php

namespace App\Entity;

use App\Repository\PossederRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PossederRepository::class)
 */
class Posseder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="posseders")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, inversedBy="posseders")
     */
    private $competence;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbRecommandation = 0;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->competence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|Competences[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competences $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        $this->competence->removeElement($competence);

        return $this;
    }

    public function getNbRecommandation(): ?int
    {
        return $this->nbRecommandation;
    }

    public function setNbRecommandation(int $nbRecommandation): self
    {
        $this->nbRecommandation = $nbRecommandation;

        return $this;
    }
}
