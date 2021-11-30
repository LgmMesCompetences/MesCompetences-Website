<?php

namespace App\Entity;

use App\Repository\PossederRepository;
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
     * @ORM\Column(type="integer")
     */
    private $nbrRecommander;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="posseders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competence;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posseders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrRecommander(): ?int
    {
        return $this->nbrRecommander;
    }

    public function setNbrRecommander(int $nbrRecommander): self
    {
        $this->nbrRecommander = $nbrRecommander;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
