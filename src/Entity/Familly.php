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
    #[Groups(['Famillies:read', 'Familly:read'])]
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    #[NotBlank]
    #[Groups(['Famillies:read', 'Familly:read'])]
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=Sheet::class, mappedBy="familly", orphanRemoval=true)
     */
    #[Groups(['Familly:read'])]
    private Collection $sheets;

    /**
     * @ORM\OneToMany(targetEntity=Spec::class, mappedBy="familly", orphanRemoval=true)
     */
    private Collection $specs;

    /**
     * @ORM\OneToMany(targetEntity=Module::class, mappedBy="familly")
     */
    #[Groups(['Familly:read'])]
    private Collection $modules;

    public function __construct()
    {
        $this->sheets = new ArrayCollection();
        $this->specs = new ArrayCollection();
        $this->modules = new ArrayCollection();
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
     * @return Collection|Sheet[]
     */
    public function getSheets(): Collection
    {
        return $this->sheets;
    }

    public function addSheet(Sheet $sheet): self
    {
        if (!$this->sheets->contains($sheet)) {
            $this->sheets[] = $sheet;
            $sheet->setFamilly($this);
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
            $spec->setFamilly($this);
        }

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
}
