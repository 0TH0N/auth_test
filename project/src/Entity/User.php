<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

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
     * @ORM\Column(type="string", unique=true, nullable=true)
     */
    private $apiToken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $serverTimeApiTokenRequest;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $userTimeApiTokenRequest;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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
     * @return mixed
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }

    /**
     * @param mixed $apiToken
     *
     * @return self
     */
    public function setApiToken($apiToken): self
    {
        $this->apiToken = $apiToken;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServerTimeApiTokenRequest()
    {
        return $this->serverTimeApiTokenRequest;
    }

    /**
     * @param mixed $serverTimeApiTokenRequest
     *
     * @return self
     */
    public function setServerTimeApiTokenRequest($serverTimeApiTokenRequest): self
    {
        $this->serverTimeApiTokenRequest = $serverTimeApiTokenRequest;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserTimeApiTokenRequest()
    {
        return $this->userTimeApiTokenRequest;
    }

    /**
     * @param mixed $userTimeApiTokenRequest
     *
     * @return self
     */
    public function setUserTimeApiTokenRequest($userTimeApiTokenRequest): self
    {
        $this->userTimeApiTokenRequest = $userTimeApiTokenRequest;
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
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
