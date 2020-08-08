<?php

//      __________________________________________________________________________________
//                                                                     N A M E S P A C E
//      __________________________________________________________________________________
namespace App\Entity;


//      __________________________________________________________________________________
//                                                                                U S E
//      __________________________________________________________________________________
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CountryRepository;
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
 *     normalizationContext={ "groups" = { "country:read" }, "swagger_definition_name" = "Read" }
 * )
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               I D               -               -               -
    /**
     * The id of the country
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups( { "country:read" } )
     */
    private $id;


    //      -               -               -               N A M E               -               -               -
    /**
     * The name of the country
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "country:read" } )
     */
    private $name;


    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -               U S E R S               -               -               -
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="countryId")
     */
    private $users;

    //      -               -               -               C I T I E S               -               -               -
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\City", mappedBy="countryId")
     */
    private $cities;


    //      __________________________________________________________________________________
    //                                                                        M E T H O D S
    //      __________________________________________________________________________________

    //      -               -               -              C O N S T R U C T O R               -               -               -

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->cities = new ArrayCollection();
    }


    //      -               -               -              getter ID               -               -               -
    /**
     * Get the id of the country
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    //      -               -               -              getter & setter NAME               -               -               -
    /**
     * Get the name of the country
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name of the country
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
            $user->setCountryId($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCountryId() === $this) {
                $user->setCountryId(null);
            }
        }

        return $this;
    }

    //      -               -               -              getter, adder, remover CITIES               -               -               -
    /**
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
            $city->setCountryId($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->contains($city)) {
            $this->cities->removeElement($city);
            // set the owning side to null (unless already changed)
            if ($city->getCountryId() === $this) {
                $city->setCountryId(null);
            }
        }

        return $this;
    }
}