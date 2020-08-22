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
use App\Repository\TagRepository;
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
 *     normalizationContext={ "groups" = { "tag:read" }, "swagger_definition_name" = "Read" }
 * )
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ApiFilter( SearchFilter::class, properties={
 *       "name" : "partial",
 *       "location" : "exact"
 * } )
 */
class Tag
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               I D               -               -               -
    /**
     * The id of the tag
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups( { "tag:read", "location:read" } )
     */
    private $id;


    //      -               -               -               N A M E               -               -               -
    /**
     * The name of the tag
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "tag:read", "location:read" } )
     */
    private $name;


    //      -               -               -               C A T E G O R Y               -               -               -
    /**
     * The broader category the tag belongs to
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "tag:read", "location:read" } )
     */
    private $category;


    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -               L O C A T I O N   I D               -               -               -
    /**
     * The location that has these tags
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Location", inversedBy="tags")
     * @Groups( { "tag:read" } )
     */
    private $location;



    //      __________________________________________________________________________________
    //                                                                        M E T H O D S
    //      __________________________________________________________________________________

    //      -               -               -              C O N S T R U C T O R               -               -               -

    public function __construct()
    {
        $this->location = new ArrayCollection();
    }


    //      -               -               -              getter ID               -               -               -
    /**
     * Get the id of the tag
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    //      -               -               -              getter & setter NAME               -               -               -

    /**
     * Get the name of the tag
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name of the tag
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    //      -               -               -              getter & setter CATEGORY               -               -               -
    /**
     * Get the broader category the tag belongs to
     */
        public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * Set the broader category the tag belongs to
     */
    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //    //      -               -               -              getter, adder, remover REVIEWS               -               -               -
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


      //      __________________________________________________________________________________
      //                                                                        E A S Y   A D M I N
      //      __________________________________________________________________________________
      public function __toString()
      {
            return $this->name;
      }
}