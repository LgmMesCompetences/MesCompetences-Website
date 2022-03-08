<?php

namespace App\Entity;

use App\Repository\PossederRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=PossederRepository::class)
 */
#[ApiResource(
    denormalizationContext: [
        'groups' => ['poss:write']
    ],
    normalizationContext: [
        'groups' => ['poss:read']
    ],
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_USER')"],
    ],
    itemOperations: [
        "get",
        "delete" => ["security" => "is_granted('ROLE_ADMIN') or object.user == user"],
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ["user.id"=> "exact"])]
class Posseder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(["poss:read"])]
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(["poss:read", "user:read"])]
    #[Assert\NotNull]
    private $nbrRecommander = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="posseders")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(["poss:write", "poss:read", "user:read"])]
    #[Assert\NotNull]
    private $competence;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posseders")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(["poss:write", "poss:read"])]
    #[Assert\NotNull]
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
