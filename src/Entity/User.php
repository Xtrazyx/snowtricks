<?php

namespace App\Entity;

use App\Traits\FromArrayTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"})}, indexes={@ORM\Index(name="fk_User_Avatar_idx", columns={"avatar_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="L'email existe déjà, entrez un autre email.")
 */
class User implements AdvancedUserInterface, \Serializable
{
    use FromArrayTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=45, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=45, nullable=false)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=1024, nullable=false)
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(name="role", type="array", length=45, nullable=true)
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var Avatar
     *
     * @ORM\OneToOne(targetEntity="Avatar", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="avatar_id", referencedColumnName="id")
     */
    private $avatar;

    public function __construct()
    {
        $this->isActive = false;
    }

    /* ADVANCED USER INTERFACE */
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

        // Prevent inactive user from logging
    public function isEnabled()
    {
        return $this->isActive;
    }
    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }

    /* SERIALIZABLE INTERFACE */
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->roles,
            $this->isActive
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->roles,
            $this->isActive
            ) = unserialize($serialized);
    }

    /* GETTERS SETTERS */
    /**
     * @return int
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean
     */
    public function setActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return Avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param Avatar $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }
}
