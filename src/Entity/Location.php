<?php

//      __________________________________________________________________________________
//                                                                     N A M E S P A C E
//      __________________________________________________________________________________
namespace App\Entity;


//      __________________________________________________________________________________
//                                                                                U S E
//      __________________________________________________________________________________
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\LocationRepository;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

//      __________________________________________________________________________________
//                                                                             C L A S S
//      __________________________________________________________________________________
/**
 * @ApiResource(
 *     collectionOperations={ "get" },
 *     itemOperations={ "get" },
 *     normalizationContext={ "groups" = { "location:read" }, "swagger_definition_name" = "Read" },
 * )
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 * @ApiFilter( BooleanFilter::class, properties={ "isDeleted" } )
 * @ApiFilter( SearchFilter::class, properties={
 *          "name" : "partial" ,
 *          "addressText" : "partial",
 *          "tags" : "exact",
 *          "events" : "exact"
 * } )
 */
class Location
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               I D               -               -               -
    /**
     * The id of the location
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups( { "location:read", "image:read", "review:read", "tag:read", "event:read" } )
     */
    private $id;


    //      -               -               -               N A M E               -               -               -
    /**
     * The name of the location
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "location:read", "image:read", "review:read", "tag:read", "event:read" } )
     */
    private $name;


    //      -               -               -               U N I Q U E   P R O P E R T Y               -               -               -
    /**
     * The unique property of this location
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "location:read" } )
     */
    private $uniqueProperty;


    //      -               -               -               A D D R E S S   T E X T               -               -               -
    /**
     * The address in text form, how it will show on the website
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "location:read", "image:read", "review:read" } )
     */
    private $addressText;


    //      -               -               -               A D D R E S S   I N F O               -               -               -
    /**
     * The address information, what the map needs
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "location:read", "image:read", "review:read" } )
     */
    private $addressInfo;


    //      -               -               -               D E S C R I P T I O N               -               -               -
    /**
     * The description of the location
     *
     * @ORM\Column(type="text")
     * @Groups( { "location:read" } )
     */
    private $description;


    //      -               -               -               C R E A T E D   A T               -               -               -
    /**
     * When the entry of the location was created
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    //      -               -               -               I S   D E L E T E D               -               -               -
    /**
     * Whether or not the location has been visually deleted from the website
     *
     * @ORM\Column(type="boolean")
     * @Groups( { "location:read", "image:read", "review:read", "tag:read", "event:read" } )
     */
    private $isDeleted = false;

    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -               I M A G E S               -               -               -
    /**
     * The images of this location
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="location")
     * @Groups( { "location:read" } )
     */
    private $images;

    //      -               -               -               R E V I E W S               -               -               -
    /**
     * The reviews about this location
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="location")
     * @Groups( { "location:read" } )
     */
    private $reviews;


    //      -               -               -               T A G S               -               -               -
    /**
     * The tags belonging to this location
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", mappedBy="locations", cascade= {"persist" } )
     * @Groups( { "location:read", "tag:read" } )
     */
    private $tags;


    //      -               -               -               E V E N T S               -               -               -
    /**
     * The events hosted on this location
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", mappedBy="location")
     * @Groups( { "location:read" } )
     */
    private $events;


    //      __________________________________________________________________________________
    //                                                                        M E T H O D S
    //      __________________________________________________________________________________

    //      -               -               -              C O N S T R U C T O R               -               -               -

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->images = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->events = new ArrayCollection();
    }


    //      -               -               -              getter ID               -               -               -
    /**
     * Get the id of the location
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    //      -               -               -              getter & setter NAME               -               -               -
    /**
     * Get the name of the location
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name of the location
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    //      -               -               -              getter & setter UNIQUE PROPERTY               -               -               -
    /**
     * Get the unique property of this location
     */
    public function getUniqueProperty(): ?string
    {
        return $this->uniqueProperty;
    }

    /**
     * Set the unique property of this location
     */
    public function setUniqueProperty(string $uniqueProperty): self
    {
        $this->uniqueProperty = $uniqueProperty;

        return $this;
    }


    //      -               -               -              getter & setter ADDRESS TEXT               -               -               -
    /**
     * Get the address in text form, how it will show on the website
     */
    public function getAddressText(): ?string
    {
        return $this->addressText;
    }

    /**
     * Set the address in text form, how it will show on the website
     */
    public function setAddressText(string $addressText): self
    {
        $this->addressText = $addressText;

        return $this;
    }


    //      -               -               -              getter & setter ADDRESS INFO               -               -               -
    /**
     * Get the address information, what the map needs
     */
    public function getAddressInfo(): ?string
    {
        return $this->addressInfo;
    }

    /**
     * Set the address information, what the map needs
     */
    public function setAddressInfo(string $addressInfo): self
    {
        $this->addressInfo = $addressInfo;

        return $this;
    }


    //      -               -               -              getter & setter DESCRIPTION               -               -               -
    /**
     * Get the description of the location
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the description of the location
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    //      -               -               -              getter & setter CREATED AT               -               -               -
    /**
     * Get when the entry of the location was created
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Get when the entry of the location was created, written as time ago
     *
     * @Groups( { "location:read" } )
     * @SerializedName( "createdAt" )
     */
    public function getCreatedAtAgo(): string
    {
        return Carbon::instance( $this->getCreatedAt() )->diffForHumans();
    }

      /**
       * Set when the entry of the location was created
       */
      public function setCreatedAt(\DateTimeInterface $createdAt): self
      {
            $this->createdAt = $createdAt;

            return $this;
      }


    //      -               -               -              getter & setter IS DELETED               -               -               -
    /**
     * Get whether or not the location entry is visually deleted from the website
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * Set whether or not the location entry is visually deleted from the website
     */
    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }


    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -              getter, adder, remover IMAGES               -               -               -
    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setLocation($this);
        }

        return $this;
    }

        public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getLocation() === $this) {
                $image->setLocation(null);
            }
        }

        return $this;
    }

    //      -               -               -              getter, adder, remover REVIEWS               -               -               -
    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setLocation($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getLocation() === $this) {
                $review->setLocation(null);
            }
        }

        return $this;
    }

    //    -               -               -              getter, adder, remover TAGS               -               -               -
    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addLocation($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeLocation($this);
        }

        return $this;
    }

    //      -               -               -              getter, adder, remover EVENTS               -               -               -
    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addLocation($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeLocation($this);
        }

        return $this;
    }


      //      __________________________________________________________________________________
      //                                                                        E A S Y   A D M I N
      //      __________________________________________________________________________________
      public function __toString()
      {
            return $this->name;
      }
}