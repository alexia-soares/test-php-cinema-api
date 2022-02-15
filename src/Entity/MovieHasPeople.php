<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'movie_has_people')]
#[ORM\Entity]
#[ApiResource(
    collectionOperations: [
        "get",
        "post" => ["security" => "is_granted('ROLE_USER')"],
    ],
    itemOperations: [
        "get",
        "put" => ["security" => "is_granted('ROLE_USER')"],
        "delete" => ["security" => "is_granted('ROLE_USER')"],
        "patch" => ["security" => "is_granted('ROLE_USER')"],
    ],
)]
class MovieHasPeople
{
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $role;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $significance = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: People::class, cascade: ['persist'], fetch: 'EAGER', inversedBy: 'movieHasPeoples')]
    #[ORM\JoinColumn(name: 'People_id', referencedColumnName: 'id', nullable: false, onDelete: 'cascade')]
    private People $people;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Movie::class, cascade: ['persist', 'remove'], inversedBy: 'movieHasPeoples')]
    #[ORM\JoinColumn(name: 'Movie_id', referencedColumnName: 'id', nullable: false, onDelete: 'cascade')]
    private Movie $movie;

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): MovieHasPeople
    {
        $this->role = $role;
        return $this;
    }

    public function getSignificance(): ?string
    {
        return $this->significance;
    }

    public function setSignificance(?string $significance): MovieHasPeople
    {
        $this->significance = $significance;

        return $this;
    }

    public function getPeople(): People
    {
        return $this->people;
    }

    public function setPeople(People $people): MovieHasPeople
    {
        $this->people = $people;

        return $this;
    }

    public function getMovie(): Movie
    {
        return $this->movie;
    }

    public function setMovie(Movie $movie): MovieHasPeople
    {
        $this->movie = $movie;

        return $this;
    }
}
