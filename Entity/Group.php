<?php

declare(strict_types=1);

namespace Symbio\OrangeGate\UserBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Standalone group entity for legacy fos_user_group (Sonata User 5 removed BaseGroup).
 */
#[ORM\Entity]
#[ORM\Table(name: 'fos_user_group')]
class Group
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
    protected ?string $name = null;

    /** @var list<string> */
    #[ORM\Column(type: Types::JSON)]
    protected array $roles = [];

    /**
     * @param list<string> $roles
     */
    public function __construct(?string $name = null, array $roles = [])
    {
        $this->name = $name;
        $this->roles = $roles;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return list<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): self
    {
        $role = strtoupper($role);

        if (!$this->hasRole($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(string $role): self
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    public function hasRole(string $role): bool
    {
        return \in_array(strtoupper($role), $this->roles, true);
    }
}
