<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FamillyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=FamillyRepository::class)
 */
#[
    UniqueEntity(fields: 'name', message: 'Le nom est déjà utilisé.'),
    ApiResource(
        collectionOperations: [
            'GET' => [
                'normalization_context' => ['groups' => ['Famillies:read']],
                'openapi_context' => ['security' => [['bearerAuth' => []]]]
            ]
        ],
        itemOperations: ['GET' => [
            'normalization_context' => ['groups' => ['Familly:read']],
            'openapi_context' => ['security' => [['bearerAuth' => []]]]
        ]],
        paginationEnabled: false,
    )
]
class Familly
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['Famillies:read', 'Familly:read', 'ModuleApi:read', 'Vegetable:read'])]
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    #[NotBlank]
    #[Groups(['Famillies:read', 'Familly:read', 'ModuleApi:read', 'Vegetable:read'])]
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=Module::class, mappedBy="familly")
     */
    #[Groups(['Familly:read'])]
    private Collection $modules;

    /**
     * @ORM\OneToMany(targetEntity=ActionCondition::class, mappedBy="family")
     */
    private $actionConditions;

    /**
     * @ORM\OneToMany(targetEntity=Spec::class, mappedBy="family")
     */
    private $specs;

    /**
     * @ORM\OneToMany(targetEntity=Vegetable::class, mappedBy="family")
     */
    private $vegetables;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
        $this->actionConditions = new ArrayCollection();
        $this->specs = new ArrayCollection();
        $this->vegetables = new ArrayCollection();
    }

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

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->setFamilly($this);
        }

        return $this;
    }

    /**
     * @return Collection|ActionCondition[]
     */
    public function getActionConditions(): Collection
    {
        return $this->actionConditions;
    }

    public function addActionCondition(ActionCondition $actionCondition): self
    {
        if (!$this->actionConditions->contains($actionCondition)) {
            $this->actionConditions[] = $actionCondition;
            $actionCondition->setFamily($this);
        }

        return $this;
    }

    public function removeActionCondition(ActionCondition $actionCondition): self
    {
        if ($this->actionConditions->removeElement($actionCondition)) {
            // set the owning side to null (unless already changed)
            if ($actionCondition->getFamily() === $this) {
                $actionCondition->setFamily(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Spec[]
     */
    public function getSpecs(): Collection
    {
        return $this->specs;
    }

    public function addSpec(Spec $spec): self
    {
        if (!$this->specs->contains($spec)) {
            $this->specs[] = $spec;
            $spec->setFamily($this);
        }

        return $this;
    }

    public function removeSpec(Spec $spec): self
    {
        if ($this->specs->removeElement($spec)) {
            // set the owning side to null (unless already changed)
            if ($spec->getFamily() === $this) {
                $spec->setFamily(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vegetable[]
     */
    public function getVegetables(): Collection
    {
        return $this->vegetables;
    }

    public function addVegetable(Vegetable $vegetable): self
    {
        if (!$this->vegetables->contains($vegetable)) {
            $this->vegetables[] = $vegetable;
            $vegetable->setFamily($this);
        }

        return $this;
    }

    public function removeVegetable(Vegetable $vegetable): self
    {
        if ($this->vegetables->removeElement($vegetable)) {
            // set the owning side to null (unless already changed)
            if ($vegetable->getFamily() === $this) {
                $vegetable->setFamily(null);
            }
        }

        return $this;
    }

    public function __invoke(): array
    {
        return $this->name;
    }
}
