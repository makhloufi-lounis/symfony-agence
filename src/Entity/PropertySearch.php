<?php
/**
 * Teeps API Server
 *
 * @version   1.0
 * @author    Lounis Makhloufi <makhloufi.lounis@gmail.com>
 * @see       https://github.com/makhloufi-lounis/symfony-agence.git for the canonical source repository
 * @copyright Copyright (c) 2020 Agence.
 */

declare(strict_types=1);


namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PropertySearch
 * @package App\Entity
 */
class PropertySearch
{

    /**
     * @var int|null
     * @Assert\Range(min=10)
     */
    private $minPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10)
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(min=10)
     */
    private $minArea;

    /**
     * @var int|null
     * @Assert\Range(min=10)
     */
    private $maxArea;

    /**
     * @var string|null
     */
    private $activities;

    /**
     * @var string|null
     */
    private $locations;

    /**
     * @var ArrayCollection
     */
    private $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

    /**
     * @param int|null $minPrice
     */
    public function setMinPrice(int $minPrice): void
    {
        $this->minPrice = $minPrice;
    }

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     */
    public function setMaxPrice(int $maxPrice): void
    {
        $this->maxPrice = $maxPrice;
    }

    /**
     * @return int|null
     */
    public function getMinArea(): ?int
    {
        return $this->minArea;
    }

    /**
     * @param int|null $minArea
     */
    public function setMinArea(int $minArea): void
    {
        $this->minArea = $minArea;
    }

    /**
     * @return int|null
     */
    public function getMaxArea(): ?int
    {
        return $this->maxArea;
    }

    /**
     * @param int|null $maxArea
     */
    public function setMaxArea(int $maxArea): void
    {
        $this->maxArea = $maxArea;
    }

    /**
     * @return string|null
     */
    public function getActivities(): ?string
    {
        return $this->activities;
    }

    /**
     * @param string $activities
     */
    public function setActivities(string $activities): void
    {
        $this->activities = $activities;
    }

    /**
     * @return string|null
     */
    public function getLocations(): ?string
    {
        return $this->locations;
    }

    /**
     * @param string $locations
     */
    public function setLocations(string $locations): void
    {
        $this->locations = $locations;
    }

    /**
     * @return ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     */
    public function setOptions(ArrayCollection $options): void
    {
        $this->options = $options;
    }

}