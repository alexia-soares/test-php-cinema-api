<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'type')]
#[ORM\Entity]
#[ApiResource(
    collectionOperations: [
        'get',
        'post' => ['security' => "is_granted('ROLE_USER')"],
    ],
    itemOperations: [
        'get',
        'put' => ['security' => "is_granted('ROLE_USER')"],
        'delete' => ['security' => "is_granted('ROLE_USER')"],
        'patch' => ['security' => "is_granted('ROLE_USER')"],
    ],
)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer', nullable: false)]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'types')]
    private Collection $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Type
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Type
    {
        $this->name = $name;

        return $this;
    }

    public function getMovies(): ArrayCollection|Collection
    {
        return $this->movies;
    }

    public function setMovies(ArrayCollection|Collection $movies): Type
    {
        $this->movies = $movies;

        return $this;
    }
}
