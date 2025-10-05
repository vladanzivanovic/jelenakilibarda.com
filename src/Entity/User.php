<?php

namespace App\Entity;

use App\Entity\Traits\ResourceTrait;
use App\Entity\Traits\StatusTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, EntityInterface
{
    use TimestampableEntity;
    use ResourceTrait;
    use StatusTrait;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="field.required", groups={"SetUser", "SetUserAdmin"})
     */
    private ?string $email = null;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string|null The hashed password
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank(message="field.required", groups={"SetUser", "SetUserAdmin"})
     * @Assert\EqualTo(message="field.password_not_equal", propertyPath="rePassword", groups={"SetUser"})
     */
    private ?string $password = null;

    /**
     * @var string|null The hashed password
     */
    private ?string $rePassword = null;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="field.required", groups={"SetUser", "SetUserAdmin"})
     */
    private ?string $firstName = null;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="field.required", groups={"SetUser", "SetUserAdmin"})
     */
    private ?string $lastName = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $resetToken = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $resetRequestAt = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $note = null;

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
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRePassword(): ?string
    {
        return $this->rePassword;
    }

    public function setRePassword(string $rePassword): self
    {
        $this->rePassword = $rePassword;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getResetRequestAt(): ?\DateTimeInterface
    {
        return $this->resetRequestAt;
    }

    public function setResetRequestAt(?\DateTimeInterface $resetRequestAt): self
    {
        $this->resetRequestAt = $resetRequestAt;

        return $this;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function isAccountCreated(): bool
    {
        return null !== $this->getResetToken();
    }
}
