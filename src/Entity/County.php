<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CountyRepository")
 */
class County
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\state", inversedBy="counties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "tax rate must be at least {{ limit }}",
     *      maxMessage = "tax cannot be more than {{ limit }}"
     * )
     * @ORM\Column(type="float")
     */
    private $taxRate;

    /**
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "tax rate must be at least {{ limit }}"
     * )
     * @ORM\Column(type="float")
     */
    private $income;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getState(): ?state
    {
        return $this->state;
    }

    public function setState(?state $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getTaxRate(): ?float
    {
        return $this->taxRate;
    }

    public function setTaxRate(float $taxRate): self
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getIncome(): ?float
    {
        return $this->income;
    }

    public function setIncome(float $income): self
    {
        $this->income = $income;

        return $this;
    }
}
