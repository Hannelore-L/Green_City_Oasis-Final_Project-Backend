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
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


//      __________________________________________________________________________________
//                                                                             C L A S S
//      __________________________________________________________________________________
/**
 * @ApiResource(
 *     collectionOperations={ "get" },
 *     itemOperations={ "get" },
 *     normalizationContext={ "groups" = { "event:read" }, "swagger_definition_name" = "Read" }
 * )
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @ApiFilter( SearchFilter::class, properties={ "name" : "partial" } )
 */
class Event
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               I D               -               -               -
    /**
     * The id of the event
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups( { "event:read" } )
     */
    private $id;


    //      -               -               -               N A M E               -               -               -
    /**
     * The name of the event
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "event:read" } )
     */
    private $name;


    //      -               -               -               D E S C R I P T I O N               -               -               -
    /**
     * The short description of the event
     *
     * @ORM\Column(type="text")
     * @Groups( { "event:read" } )
     */
    private $description;


    //      -               -               -               L I N K               -               -               -
    /**
     * The link to the official event page, if this exists
     *
     * @ORM\Column(type="string", length=512, nullable=true)
     * @Groups( { "event:read" } )
     */
    private $link;


    //      -               -               -               S T A R T   D A T E               -               -               -
    /**
     * The start date of the event
     *
     * @ORM\Column(type="date")
     * @Groups( { "event:read" } )
     */
    private $startDate;


    //      -               -               -               E N D   D A T E               -               -               -
    /**
     * The end date of the event
     *
     * @ORM\Column(type="date")
     * @Groups( { "event:read" } )
     */
    private $endDate;


    //      -               -               -               S T A R T   T I M E               -               -               -
    /**
     * The start time of the event
     *
     * @ORM\Column(type="time")
     * @Groups( { "event:read" } )
     */
    private $startTime;


    //      -               -               -               E N D   T I M E               -               -               -
    /**
     * The end time of the event
     *
     * @ORM\Column(type="time")
     * @Groups( { "event:read" } )
     */
    private $endTime;


    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -               L O C A T I O N   I D               -               -               -
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location", inversedBy="events")
     * @Groups( { "event:read" } )
     */
    private $location;

    public function __construct()
    {
        $this->location = new ArrayCollection();
    }


    //      __________________________________________________________________________________
    //                                                                        M E T H O D S
    //      __________________________________________________________________________________

    //      -               -               -              getter ID               -               -               -
    /**
     * Get the id of the event
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    //      -               -               -              getter & setter NAME               -               -               -
    /**
     * Get the name of the event
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name of the event
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    //      -               -               -              getter & setter DESCRIPTION               -               -               -
    /**
     * Get the short description of the event
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the short description of the event
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    //      -               -               -              getter & setter LINK               -               -               -
    /**
     * Get the link to the official event page, if this exists
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * Set the link to the official event page, if this exists
     */
    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }


    //      -               -               -              getter & setter START DATE               -               -               -
    /**
     * Get the start date of the event
     */
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * Set the start date of the event
     */
    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }


    //      -               -               -              getter & setter END DATE               -               -               -
    /**
     * Get the end date of the event
     */
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * Set the end date of the event
     */
    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }


    //      -               -               -              getter & setter START TIME               -               -               -
    /**
     * Get the start time of the event
     */
    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    /**
     * Set the start time of the event
     */
    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }


    //      -               -               -              getter & setter END TIME               -               -               -
    /**
     * Get the end time of the event
     */
    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    /**
     * Set the end time of the event
     */
    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }


    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -              getter, adder, remover LOCATION ID               -               -               -
    /**
     * @return Collection|location[]
     */
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(location $location): self
    {
        if (!$this->location->contains($location)) {
            $this->location[] = $location;
        }

        return $this;
    }

    public function removeLocation(location $location): self
    {
        if ($this->location->contains($location)) {
            $this->location->removeElement($location);
        }

        return $this;
    }
}