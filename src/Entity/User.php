<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ResetPasswordController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
#[
    ApiResource(
        collectionOperations: [
            'generateToken' => [
                'method' => 'POST',
                'path' => '/users/password-token',
                'controller' => ResetPasswordController::class,
                'read' => false,
                'write' => false,

                'openapi_context' => [
                    'summary' => 'Step 1 to update a forgotten password',
                    'description' => 'Generate a token and send a link by email.',
                    'tags' => ['Forgotten password'],

                    'requestBody' => [
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'required' => 'email',
                                    'properties' => [
                                        'email' => [
                                            'type' => 'string',
                                            'example' => 'admin@domain.net'
                                        ]
                                    ]
                                ],
                            ]
                        ]
                    ],
                    'responses' => [
                        '200' => [
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',

                                        'properties' => [
                                            'token' => [
                                                'type' => 'string',
                                                'example' => '4155fe05-29bf-4f54-99c0-8141a105fd72'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],

        'refreshPassword' => [
            'method' => 'POST',
            'path' => '/users/password-refresh',
            'controller' => ResetPasswordController::class,
            'read' => false,
            'write' => false,

            'openapi_context' => [
                'summary' => 'Step 2 to update a forgotten password',
                'description' => 'Change the password for an user.',
                'tags' => ['Forgotten password'],

                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'required' => 'password',
                                'properties' => [
                                    'token' => [
                                        'type' => 'string',
                                        'example' => '4155fe05-29bf-4f54-99c0-8141a105fd72'
                                    ],
                                    'password' => [
                                        'type' => 'string',
                                        'example' => 'mon_nouveau_mot_de_passe'
                                    ],
                                ]
                            ],
                        ]
                    ]
                ],
                'responses' => [
                    '200' => [
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',

                                    'properties' => [
                                        'message' => [
                                            'type' => 'string',
                                            'example' => 'Le mot de passe est modifié.'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    '201' => null,
                    '400' => [
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',

                                    'properties' => [
                                        'message' => [
                                            'type' => 'string',
                                            'example' => 'message d\'erreur.'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
        ],
        itemOperations: []
    )
]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     * @var array<string> $roles
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Module::class, mappedBy="user", orphanRemoval=true)
     */
    private Collection $modules;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string|null $passwordToken;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $module->setUser($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getUser() === $this) {
                $module->setUser(null);
            }
        }

        return $this;
    }

    public function getPasswordToken(): ?string
    {
        return $this->passwordToken;
    }

    public function setPasswordToken(?string $passwordToken): self
    {
        $this->passwordToken = $passwordToken;

        return $this;
    }
}
