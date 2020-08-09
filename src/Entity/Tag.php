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
 * @ApiFilter( SearchFilter::class, properties={ "name" : "partial" } )
 */
class Tag
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               I D               -               -               -
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups( { "tag:read" } )
     */
    private $id;


    //      -               -               -               N A M E               -               -               -
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups( { "tag:read" } )
     */
    private $name;


    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -               L O C A T I O N   I D               -               -               -
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Location", inversedBy="tags")
     * @Groups( { "tag:read" } )
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
    public function getId(): ?int
    {
        return $this->id;
    }


    //      -               -               -              getter & setter NAME               -               -               -
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
}