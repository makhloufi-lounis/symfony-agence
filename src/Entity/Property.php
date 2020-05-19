<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 * @Vich\Uploadable
 */
class Property
{
    public const BLOCK_NAME_ADMIN = 'admin';
    public const BLOCK_NAME_PUBLIC = 'public';

    public const STATUS_PUBLIC = 'public';
    public const STATUS_WAITING = 'waiting';
    public const STATUS_REQUEST_PUBLICATION = 'request_publication';
    public const STATUS_DELETED = 'deleted';
    public const STATUS_ARCHIVED = 'archived';

    public const STATUS = [
        'public' => 'Publique',
        'waiting' => 'Attente',
        'request_publication' => 'Demande publication',
        'deleted' => 'Supprimée',
        'archived' => 'Archivée'
    ];


    public const HEAT = [
        0 => 'Eléctric',
        1 => 'Gaz',
        2 => 'Central'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10, max=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=10)
     */
    private $area;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=0)
     */
    private $rooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=0)
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=0)
     */
    private $floor = 0;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=0)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $heat;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, max=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3, max=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Regex("/^[0-9]{2}\s[0-9]{3}/")
     */
    private $postalCode;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $sold = false;

    /**
     * @ORM\Column(type="string", length=45, options={"default": "public"})
     */
    private $status = 'public';

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "real_estate"})
     */
    private $activity = 'real_estate';

    /**
     * @ORM\ManyToMany(targetEntity=Option::class, inversedBy="properties")
     */
    private $options;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="imageName")
     *
     * @var File|null
     * @Assert\Image(mimeTypes="image/jpeg")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string|null
     */
    private $imageName;


    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->options = new ArrayCollection();
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        $slugify = new Slugify();
        return $slugify->slugify(strtolower($this->title));
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getArea(): ?int
    {
        return $this->area;
    }

    /**
     * @param int $area
     * @return $this
     */
    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    /**
     * @param int $rooms
     * @return $this
     */
    public function setRooms(?int $rooms): self
    {
        $this->rooms = (int) $rooms;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    /**
     * @param int $bedrooms
     * @return $this
     */
    public function setBedrooms(?int $bedrooms): self
    {
        $this->bedrooms = (int) $bedrooms;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getFloor(): ?int
    {
        return $this->floor;
    }

    /**
     * @param int $floor
     * @return $this
     */
    public function setFloor(?int $floor): self
    {
        $this->floor = (int)$floor;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return $this
     */
    public function setPrice(?int $price): self
    {
        $this->price = (int)$price;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getHeat(): ?int
    {
        return $this->heat;
    }

    /**
     * @param int $heat
     * @return $this
     */
    public function setHeat(int $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    /**
     * @return string
     */
    public function getHeatType(): string
    {
        return self::HEAT[$this->heat];
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

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
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

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
     * @return bool|null
     */
    public function getSold(): ?bool
    {
        return $this->sold;
    }

    /**
     * @param bool $sold
     * @return $this
     */
    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Property
     */
    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string|null $reference
     * @return $this
     */
    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getActivity(): ?string
    {
        return $this->activity;
    }

    /**
     * @param string $activity
     * @return $this
     */
    public function setActivity(string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    /**
     * @param Option $option
     * @return $this
     */
    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addProperty($this);
        }

        return $this;
    }

    /**
     * @param Option $option
     * @return $this
     */
    public function removeOption(Option $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
            $option->removeProperty($this);
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Property
     */
    public function setImageFile(?File $imageFile): Property
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
             $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string|null $imageName
     * @return Property
     */
    public function setImageName(?string $imageName): Property
    {
        $this->imageName = $imageName;
        return $this;
    }


}
