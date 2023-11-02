<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{
    #[Assert\Range(
        min: 100,
        max: 300
    )]

    private ?int $surfaceMin = null;
    #[Assert\Positive]



    private ?int $budgetMax = null;

    /**
     * @return int|null
     */
    public function getSurfaceMin(): ?int
    {
        return $this->surfaceMin;
    }

    /**
     * @var ArrayCollection
     */
    private $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    /**
     * @param int|null $surfaceMin
     * @return PropertySearch
     */
    public function setSurfaceMin(int $surfaceMin): PropertySearch
    {
        $this->surfaceMin = $surfaceMin;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getBudgetMax(): ?int
    {
        return $this->budgetMax;
    }

    /**
     * @param int|null $budgetMax
     * @return PropertySearch
     */
    public function setBudgetMax(int $budgetMax): PropertySearch
    {
        $this->budgetMax = $budgetMax;
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getOptions(): ?ArrayCollection
    {
        return $this->options;
    }

    /**
     * @param ArrayCollection $options
     */
    public function setOptions(ArrayCollection $options): self
    {
        $this->options = $options;
        return $this;
    }
}
