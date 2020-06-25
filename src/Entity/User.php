<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Stockings::class, mappedBy="user")
     */
    private $stockings;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name = '';

    /**
     * @Assert\Length(max=4096)
     * @Assert\Length(min=6)
     */
    private $plainPassword = 'xxxxxx';

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $oldPlainPassword = 'x';


    public function __construct()
    {
        $this->stockings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __toString()
    {
        return $this->getEmail();
    }

    /**
     * @return Collection|Stockings[]
     */
    public function getStockings(): Collection
    {
        return $this->stockings;
    }

    public function addStocking(Stockings $stocking): self
    {
        if (!$this->stockings->contains($stocking)) {
            $this->stockings[] = $stocking;
            $stocking->setUser($this);
        }

        return $this;
    }

    public function removeStocking(Stockings $stocking): self
    {
        if ($this->stockings->contains($stocking)) {
            $this->stockings->removeElement($stocking);
            // set the owning side to null (unless already changed)
            if ($stocking->getUser() === $this) {
                $stocking->setUser(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $Name): self
    {
        $this->name = $Name;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password): self
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function getOldPlainPassword()
    {
        return $this->oldPlainPassword;
    }

    public function setOldPlainPassword($password): self
    {
        $this->oldPlainPassword = $password;

        return $this;
    }
}
