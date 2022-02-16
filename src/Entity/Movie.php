<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'movie')]
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
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer', nullable: false)]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $title;

    #[ORM\Column(type: 'integer', nullable: false)]
    private int $duration;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $posterUrl = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: MovieHasPeople::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $movieHasPeoples;

    #[ORM\ManyToMany(targetEntity: Type::class, inversedBy: 'movies')]
    #[ORM\JoinTable(name: 'movie_has_type')]
    #[ORM\JoinColumn(name: 'Movie_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'Type_id', referencedColumnName: 'id')]
    private Collection $types;

    public function __construct()
    {
        $this->movieHasPeoples = new ArrayCollection();
        $this->types = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function getPosterUrl(): ?string
    {
        return $this->posterUrl;
    }

    public function setPosterUrl(?string $posterUrl): Movie
    {
        $this->posterUrl = $posterUrl;

        return $this;
    }

    public function getMovieHasPeoples(): ArrayCollection|Collection
    {
        return $this->movieHasPeoples;
    }

    public function setMovieHasPeoples(ArrayCollection|Collection $movieHasPeoples): Movie
    {
        $this->movieHasPeoples = $movieHasPeoples;

        return $this;
    }

    public function getTypes(): ArrayCollection|Collection
    {
        return $this->types;
    }

    public function setTypes(ArrayCollection|Collection $types): void
    {
        $this->types = $types;
    }
}
