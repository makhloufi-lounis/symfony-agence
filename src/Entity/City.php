<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $capitalName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cityName;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $postalCode;

    /**
     * @ORM\Column(type="integer")
     */
    private $areaCode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $inseeCode;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $attitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longgitude;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberInhabitants;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCapitalName(): ?string
    {
        return $this->capitalName;
    }

    public function setCapitalName(string $capitalName): self
    {
        $this->capitalName = $capitalName;

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getAreaCode(): ?int
    {
        return $this->areaCode;
    }

    public function setAreaCode(int $areaCode): self
    {
        $this->areaCode = $areaCode;

        return $this;
    }

    public function getInseeCode(): ?int
    {
        return $this->inseeCode;
    }

    public function setInseeCode(?int $inseeCode): self
    {
        $this->inseeCode = $inseeCode;

        return $this;
    }

    public function getAttitude(): ?float
    {
        return $this->attitude;
    }

    public function setAttitude(?float $attitude): self
    {
        $this->attitude = $attitude;

        return $this;
    }

    public function getLonggitude(): ?float
    {
        return $this->longgitude;
    }

    public function setLonggitude(?float $longgitude): self
    {
        $this->longgitude = $longgitude;

        return $this;
    }

    public function getNumberInhabitants(): ?int
    {
        return $this->numberInhabitants;
    }

    public function setNumberInhabitants(?int $numberInhabitants): self
    {
        $this->numberInhabitants = $numberInhabitants;

        return $this;
    }
}
