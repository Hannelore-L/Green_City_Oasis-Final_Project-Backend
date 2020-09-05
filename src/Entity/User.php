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
use App\Repository\UserRepository;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


//      __________________________________________________________________________________
//                                                                             C L A S S
//      __________________________________________________________________________________
/**
 * @ApiResource(
 *     collectionOperations={ "get", "post" },
 *     itemOperations={ "get", "delete", "put" },
 *     normalizationContext={ "groups" = { "user:read" }, "swagger_definition_name" = "Read" },
 *     denormalizationContext={ "groups" = { "user:write" }, "swagger_definition_name" = "Write" },
 *     attributes={ "pagination_enabled" = false }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiFilter( SearchFilter::class, properties={
 *       "city" : "exact",
 *        "country" : "exact"
 * } )
 * @UniqueEntity( fields={ "email" } )
 * @UniqueEntity( fields={ "displayName" } )
 */
class User implements \Symfony\Component\Security\Core\User\UserInterface
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               I D               -               -               -
    /**
     * The id of the user
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups( { "user:read", "image:read", "review:read", "city:read", "country:read" } )
     */
    private $id;


    //      -               -               -               C I T Y   I D               -               -               -
    /**
     * The id of the city the user lives in
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="users")
     * @ORM\JoinColumn(nullable=true)
     * @Groups( { "user:read", "user:write", "review:read" } )
     */
    private $city;


    //      -               -               -               C O U N T R Y   I D               -               -               -
    /**
     * The id of the country the user lives in
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups( { "user:read", "user:write" } )
     */
    private $country;


    //      -               -               -               E M A I L               -               -               -
    /**
     * The e-mail address of the user, has to be unique
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "user:read", "user:write" } )
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;


    //      -               -               -               P A S S W O R D               -               -               -
    /**
     * The password of the user
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "user:write" } )
     * @Assert\Length(
     *     min=8,
     *     minMessage="Please put a minimum of 8 characters.",
     *     max=20,
     *     maxMessage="Please do not exceed a 20 characters."
     * )
     */
    private $password;


    //      -               -               -               R O L E S               -               -               -
    /**
     * The role of the user
     *
     * @ORM\Column(type="simple_array", nullable=true)
     * @Groups( { "user:read", "image:read", "review:read", "city:read" } )
     */
    private $roles = array();


    //      -               -               -               D I S P L A Y   N A M E               -               -               -
    /**
     * The display name of the user
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "user:read", "user:write", "image:read", "review:read", "city:read", "country:read" } )
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     minMessage="Please put a minimum of 2 characters.",
     *     max=30,
     *     maxMessage="Please do not exceed a 30 characters."
     * )
     */
    private $displayName;


    //      -               -               -               F I R S T   N A M E               -               -               -
    /**
     * The first name of the user
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "user:read", "user:write" } )
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     minMessage="Please put a minimum of 2 characters.",
     *     max=30,
     *     maxMessage="Please do not exceed a 30 characters."
     * )
     */
    private $firstName;


    //      -               -               -               L A S T   N A M E               -               -               -
    /**
     * The last name of the user
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "user:read", "user:write" } )
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     minMessage="Please put a minimum of 2 characters.",
     *     max=30,
     *     maxMessage="Please do not exceed a 30 characters."
     * )
     */
    private $lastName;


    //      -               -               -               C R E A T E D   A T               -               -               -
    /**
     * The time when the user made their account
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    //      -               -               -               R E G K E Y               -               -               -
    /**
     * The regkey for the user
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $regkey;


    //      __________________________________________________________________________________
    //                                                                        R E L A T I O N S
    //      __________________________________________________________________________________

    //      -               -               -               I M A G E S               -               -               -
    /**
     * The images uploaded by this user
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="user")
     * @Groups( { "user:read" } )
     */
    private $images;

    //      -               -               -               R E V I E W S               -               -               -
    /**
     * The reviews posted by this user
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="user")
     * @Groups( { "user:read" } )
     */
    private $reviews;

      private $passwordEncoder;
    //      __________________________________________________________________________________
    //                                                                        M E T H O D S
    //      __________________________________________________________________________________

    //      -               -               -              C O N S T R U C T O R               -               -               -

    public function __construct()
    {

          $this->roles[] = 'ROLE_USER';
          $this->createdAt = new \DateTimeImmutable();
          $this->images = new ArrayCollection();
          $this->reviews = new ArrayCollection();
    }


    //      -               -               -              getter ID               -               -               -
    /**
     * Get the id of the user
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    //      -               -               -              getter & setter CITY ID               -               -               -
    /**
     * Get the id of the city the user lives in
     */
    public function getCity(): ?city
    {
        return $this->city;
    }

    /**
     * Set the id of the city the user lives in
     */
    public function setCity(?city $city): self
    {
        $this->city = $city;

        return $this;
    }


    //      -               -               -              getter & setter COUNTRY ID               -               -               -
    /**
     * Get the id of the country the user lives in
     */
    public function getCountry(): ?country
    {
        return $this->country;
    }

    /**
     * Set the id of the country the user lives in
     */
    public function setCountry(?country $country): self
    {
        $this->country = $country;

        return $this;
    }


    //      -               -               -              getter & setter EMAIL               -               -               -
    /**
     * Get the e-mail address of the user, has to be unique
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the e-mail address of the user, has to be unique
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    //      -               -               -              getter USERNAME               -               -               -
    /**
     * Get the username of the user
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }


    //      -               -               -              getter & setter ROLES               -               -               -
    /**
     * Get the role of the user
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Set the role of the user
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    //      -               -               -              getter & setter PASSWORD               -               -               -
    /**
     * Get the password of the user
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the password of the user
     */
      public function setPassword(string $password): self
      {
            $this->password = $password;

            return $this;
      }


    //      -               -               -              getter SALT               -               -               -
    public function getSalt()
    {
    }

    //      -               -               -              ERASE CREDENTIALS               -               -               -
    public function eraseCredentials()
    {
    }


    //      -               -               -              getter & setter DISPLAY NAME               -               -               -
    /**
     * Get the display name of the user
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * Set the display name of the user
     */
    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }


    //      -               -               -              getter & setter FIRST NAME               -               -               -
    /**
     * Get the first name of the user
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set the first name of the user
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }


    //      -               -               -              getter & setter LAST NAME               -               -               -
    /**
     * Get the last name of the user
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set the last name of the user
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }


    //      -               -               -              getter & setter CREATED AT               -               -               -
    /**
     * Get the time when the user made their account
     *
     * @Groups( { "user:read", "image:read", "review:read", "city:read", "country:read" } )
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Get the time when the user made their account, written as time ago
     *
     * @Groups( { "user:read", "image:read", "review:read", "city:read", "country:read" } )
     */
    public function getCreatedAtAgo(): string
    {
        return Carbon::instance( $this->getCreatedAt() )->diffForHumans();
    }


    //      -               -               -              getter & setter REGKEY               -               -               -
    /**
     * Get the regkey for the user
     */
    public function getRegkey(): ?string
    {
        return $this->regkey;
    }

    /**
     * Set the regkey for the user
     */
    public function setRegkey(string $regkey): self
    {
        $this->regkey = $regkey;

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
            $image->setUser($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
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
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }


      //      __________________________________________________________________________________
      //                                                                        E A S Y   A D M I N
      //      __________________________________________________________________________________
      public function __toString()
      {
            return $this->email;
      }
}