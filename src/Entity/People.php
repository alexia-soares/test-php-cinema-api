<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'people')]
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
class People
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer', nullable: false)]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $firstname;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $lastname;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private \DateTime $dateOfBirth;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $nationality;

    #[ORM\OneToMany(mappedBy: 'people', targetEntity: MovieHasPeople::class, cascade: ['persist'])]
    private Collection $movieHasPeoples;

    public function __construct()
    {
        $this->movieHasPeoples = new ArrayCollection();
    }

    public function getMovie(): ArrayCollection
    {
        return $this->movie;
    }

    public function setMovie(ArrayCollection $movie): void
    {
        $this->movie = $movie;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getDateOfBirth(): \DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTime $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getNationality(): string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): void
    {
        $this->nationality = $nationality;
    }

    public function getMovieHasPeoples(): ArrayCollection|Collection
    {
        return $this->movieHasPeoples;
    }

    public function setMovieHasPeoples(ArrayCollection|Collection $movieHasPeoples): People
    {
        $this->movieHasPeoples = $movieHasPeoples;

        return $this;
    }
}
