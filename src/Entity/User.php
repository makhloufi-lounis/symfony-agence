<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"username"},
 *     message="L'identifiant que vous avez indiqué est déja utilisé !"
 * )
 * @UniqueEntity(
 *     fields={"email"},
 *     message="L'email que vous avez indiqué est déja utilisé !"
 * )
 */
class User implements UserInterface, \Serializable
{

    public const CIVILITY_MALE = 'male';
    public const CIVILITY_FEMININE = 'feminine';

    public const USER_TYPE_BUYER = 'buyer';
    public const USER_TYPE_SELLER = 'seller';
    public const USER_TYPE_AGENCY = 'agency';

    public const USER_STATUS_TO_VALIDATE = 'to_validate';
    public const USER_STATUS_REGISTERED = 'registered';
    public const USER_STATUS_DELETED = 'deleted';

    public const USER_ROLE_USER = 'ROLE_USER';
    public const USER_ROLE_ADMIN = 'ROLE_ADMIN';

    public const CIVILITY = [
        'male' => 'Masculin',
        'feminine' => 'Féminin'
    ];

    public const USER_TYPES = [
        'buyer' => 'Acheteur',
        'seller' => 'Vendeur',
        'agency' => 'Agence'
    ];

    public const USER_STATUS = [
        'to_validate' => 'A valider',
        'registered' => 'Inscrit',
        'deleted' => 'Supprimé'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\Choice({"male", "feminine"}, message="La civilité n'est pas valide !")
     */
    private $civility;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=3, minMessage="Le prénom doit faire entre 3 et 255 caractères !",
     *     max=255, maxMessage="Le prénom doit faire entre 3 et 255 caractères !",
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=3, minMessage="Le nom doit faire entre 3 et 255 caractères !",
     *     max=255, maxMessage="Le nom doit faire entre 3 et 255 caractères !"
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=5, minMessage="Le nom d'utilisateur doit faire entre 3 et 255 caractères !",
     *     max=255, maxMessage="Le nom d'utilisateur doit faire entre 3 et 255 caractères !"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=8, minMessage="Le nom d'utilisateur doit faire entre 3 et 255 caractères !",
     *     max=255, maxMessage="Le nom d'utilisateur doit faire entre 3 et 255 caractères !"
     * )
     */
    private $password;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(message="Le format de l'adresse email n'est pas valide !")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[0-9]{0,10}/", message="Le format du numero de théléphone n'est pas valide !")
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, options={"default": "algerie"})
     * @Assert\Length(
     *     min=3, minMessage="Le pays doit faire entre 3 et 255 caractères !",
     *     max=255, maxMessage="Le pays doit faire entre 3 et 255 caractères !"
     * )
     */
    private $country = 'algerie';

    /**
     * @ORM\ManyToOne(targetEntity=City::class)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Regex("/^[0-9]{2}[0-9]{3}/", message="Le format du code postal n'est pas valide !")
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min=8, minMessage="l'adress doit faire entre 10 et 255 caractères !",
     *     max=255, maxMessage="l'adress doit faire entre 10 et 255 caractères !"
     * )
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "to_validate"})
     * @Assert\Choice({"to_validate", "registered", "deleted"}, message="Le status n'est pas valide !")
     */
    private $status = 'to_validate';

    /**
     * @ORM\Column(type="string", length=45)
     * @Assert\Choice({"buyer", "seller", "agency"}, message="Le type d'utilisateur n'est pas valide !")
     */
    private $userType;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min=3, minMessage="Le job doit faire entre 3 et 255 caractères !",
     *     max=255, maxMessage="Le job doit faire entre 3 et 255 caractères !"
     * )
     */
    private $job;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min=3, minMessage="Le nom de la société doit faire entre 3 et 255 caractères !",
     *     max=255, maxMessage="Le nom de la société doit faire entre 3 et 255 caractères !"
     * )
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pictureUrl;

    /**
     * @ORM\Column(type="datetime")
     */
    private $requestRegistrationAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $registrationAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLoginAt;

    /**
     * @ORM\OneToMany(targetEntity=Regulation::class, mappedBy="user")
     */
    private $regulations;


    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->requestRegistrationAt = new DateTime('now');
        $this->regulations = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCivility(): ?string
    {
        return $this->civility;
    }

    /**
     * @param string $civility
     * @return $this
     */
    public function setCivility(string $civility): self
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return User
     */
    public function setCountry(string $country): User
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return City|null
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City|null $city
     * @return $this
     */
    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return $this
     */
    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return $this
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserType(): ?string
    {
        return $this->userType;
    }

    /**
     * @param string $userType
     * @return $this
     */
    public function setUserType(string $userType): self
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return array_unique($this->roles);
    }

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getJob(): ?string
    {
        return $this->job;
    }

    /**
     * @param string|null $job
     * @return $this
     */
    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string|null $companyName
     * @return $this
     */
    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    /**
     * @param string|null $pictureUrl
     * @return $this
     */
    public function setPictureUrl(?string $pictureUrl): self
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getRequestRegistrationAt(): ?\DateTimeInterface
    {
        return $this->requestRegistrationAt;
    }

    /**
     * @param \DateTimeInterface $requestRegistrationAt
     * @return $this
     */
    public function setRequestRegistrationAt(\DateTimeInterface $requestRegistrationAt): self
    {
        $this->requestRegistrationAt = $requestRegistrationAt;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getRegistrationAt(): ?\DateTimeInterface
    {
        return $this->registrationAt;
    }

    /**
     * @param \DateTimeInterface|null $registrationAt
     * @return $this
     */
    public function setRegistrationAt(?\DateTimeInterface $registrationAt): self
    {
        $this->registrationAt = $registrationAt;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getLastLoginAt(): ?\DateTimeInterface
    {
        return $this->lastLoginAt;
    }

    /**
     * @param \DateTimeInterface|null $lastLoginAt
     * @return $this
     */
    public function setLastLoginAt(?\DateTimeInterface $lastLoginAt): self
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }

    /**
     * @return Collection|Regulation[]
     */
    public function getRegulations(): Collection
    {
        return $this->regulations;
    }

    /**
     * @param Regulation $regulation
     * @return $this
     */
    public function addRegulation(Regulation $regulation): self
    {
        if (!$this->regulations->contains($regulation)) {
            $this->regulations[] = $regulation;
            $regulation->setUser($this);
        }

        return $this;
    }

    /**
     * @param Regulation $regulation
     * @return $this
     */
    public function removeRegulation(Regulation $regulation): self
    {
        if ($this->regulations->contains($regulation)) {
            $this->regulations->removeElement($regulation);
            // set the owning side to null (unless already changed)
            if ($regulation->getUser() === $this) {
                $regulation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed|string
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

}
