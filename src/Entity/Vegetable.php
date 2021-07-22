<?php

namespace App\Entity;

use App\Repository\VegetableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VegetableRepository::class)
 */
class Vegetable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $water;

    /**
     * @ORM\Column(type="integer")
     */
    private $fiber;

    /**
     * @ORM\Column(type="integer")
     */
    private $glucose;

    /**
     * @ORM\Column(type="integer")
     */
    private $protein;

    /**
     * @ORM\Column(type="integer")
     */
    private $lipid;

    /**
     * @ORM\ManyToOne(targetEntity=Familly::class, inversedBy="vegetables")
     * @ORM\JoinColumn(nullable=false)
     */
    private $family;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introText;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cultureText;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $entretienText;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $recolteText;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $culture_start;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $culture_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recolte_start;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recolte_end;

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

    public function getWater(): ?int
    {
        return $this->water;
    }

    public function setWater(int $water): self
    {
        $this->water = $water;

        return $this;
    }

    public function getFiber(): ?int
    {
        return $this->fiber;
    }

    public function setFiber(int $fiber): self
    {
        $this->fiber = $fiber;

        return $this;
    }

    public function getGlucose(): ?int
    {
        return $this->glucose;
    }

    public function setGlucose(int $glucose): self
    {
        $this->glucose = $glucose;

        return $this;
    }

    public function getProtein(): ?int
    {
        return $this->protein;
    }

    public function setProtein(int $protein): self
    {
        $this->protein = $protein;

        return $this;
    }

    public function getLipid(): ?int
    {
        return $this->lipid;
    }

    public function setLipid(int $lipid): self
    {
        $this->lipid = $lipid;

        return $this;
    }

    public function getFamily(): ?Familly
    {
        return $this->family;
    }

    public function setFamily(?Familly $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getIntroText(): ?string
    {
        return $this->introText;
    }

    public function setIntroText(?string $introText): self
    {
        $this->introText = $introText;

        return $this;
    }

    public function getCultureText(): ?string
    {
        return $this->cultureText;
    }

    public function setCultureText(?string $cultureText): self
    {
        $this->cultureText = $cultureText;

        return $this;
    }

    public function getEntretienText(): ?string
    {
        return $this->entretienText;
    }

    public function setEntretienText(?string $entretienText): self
    {
        $this->entretienText = $entretienText;

        return $this;
    }

    public function getRecolteText(): ?string
    {
        return $this->recolteText;
    }

    public function setRecolteText(?string $recolteText): self
    {
        $this->recolteText = $recolteText;

        return $this;
    }

    public function getCultureStart(): ?string
    {
        return $this->culture_start;
    }

    public function setCultureStart(?string $culture_start): self
    {
        $this->culture_start = $culture_start;

        return $this;
    }

    public function getCultureEnd(): ?string
    {
        return $this->culture_end;
    }

    public function setCultureEnd(?string $culture_end): self
    {
        $this->culture_end = $culture_end;

        return $this;
    }

    public function getRecolteStart(): ?string
    {
        return $this->recolte_start;
    }

    public function setRecolteStart(?string $recolte_start): self
    {
        $this->recolte_start = $recolte_start;

        return $this;
    }

    public function getRecolteEnd(): ?string
    {
        return $this->recolte_end;
    }

    public function setRecolteEnd(?string $recolte_end): self
    {
        $this->recolte_end = $recolte_end;

        return $this;
    }
}
