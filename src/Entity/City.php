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
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\CityRepository;
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
 *     normalizationContext={ "groups" = { "city:read" }, "swagger_definition_name" = "Read" },
 *     attributes={ "pagination_items_per_page"=2765 }
 * )
 * @ORM\Entity(repositoryClass=CityRepository::class)
 *  @ApiFilter(OrderFilter::class, properties={ "name" }, arguments={ "orderParameterName" = "order" } )
 * @ApiFilter( SearchFilter::class, properties={ "country" : "exact" } )
 */
class City
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               I D               -               -               -
    /**
     * The id of the city
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups( { "city:read", "user:read", "review:read", "country:read" } )
     */
    private $id;


    //      -               -               -               C O U N T R Y   I D               -               -               -
    /**
     * The id of the country this city belongs to
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="cities")
     * @ORM\JoinColumn(nullable=true)
     * @Groups( { "city:read", "user:read" } )
     */
    private $country;

    //      -               -               -               Z I P               -               -               -
    /**
     * The zip code of the city
     *
     * @ORM\Column(type="smallint")
     * @Groups( { "city:read", "user:read", "country:read" } )
     */
    private $zip;


    //      -               -               -               N A M E               -               -               -
    /**
     * The name of the city
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "city:read", "user:read", "review:read", "country:read" } )
     */
    private $name;


    //      -               -               -               P R O V I N C E               -               -               -
    /**
     * The province the city is located in
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups( { "city:read", "user:read", "country:read" } )
     */
    private $province;


    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -               U S E R S               -               -               -
    /**
     * The users that live in this city
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="city")
     * @Groups( { "city:read" } )
     */
    private $users;

    //      __________________________________________________________________________________
    //                                                                        M E T H O D S
    //      __________________________________________________________________________________

    //      -               -               -              C O N S T R U C T O R               -               -               -

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    //      -               -               -              getter ID               -               -               -
    /**
     * The id of the country this city belongs to
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    //      -               -               -              getter & setter COUNTRY ID               -               -               -
    /**
     * Get the id of the country this city belongs to
     */
    public function getCountry(): ?country
    {
        return $this->country;
    }

    /**
     * Set the id of the country this city belongs to
     */
    public function setCountry(?country $country): self
    {
        $this->country = $country;

        return $this;
    }


    //      -               -               -              getter & setter ZIP               -               -               -
    /**
     * Get the zip code of the city
     */
    public function getZip(): ?int
    {
        return $this->zip;
    }

    /**
     * Set the zip code of the city
     */
    public function setZip(int $zip): self
    {
        $this->zip = $zip;

        return $this;
    }


    //      -               -               -              getter & setter NAME               -               -               -
    /**
     * Get the name of the city
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name of the city
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    //      -               -               -              getter & setter PROVINCE               -               -               -
    /**
     * Get the province the city is located in
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * Set the province the city is located in
     */
    public function setProvince(?string $province): self
    {
        $this->province = $province;

        return $this;
    }


    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -              getter, adder, remover USERS               -               -               -
    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCity($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCity() === $this) {
                $user->setCity(null);
            }
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