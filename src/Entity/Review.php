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
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use App\Repository\ReviewRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;


//      __________________________________________________________________________________
//                                                                             C L A S S
//      __________________________________________________________________________________
/**
 * @ApiResource(
 *     collectionOperations={ "get", "post" },
 *     itemOperations={ "get", "put" },
 *     normalizationContext={ "groups" = { "review:read" }, "swagger_definition_name" = "Read"  },
 *     denormalizationContext={ "groups" = { "review:write" }, "swagger_definition_name" = "Write"  }
 * )
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 * @ApiFilter( BooleanFilter::class, properties={ "isDeleted" } )
 * @ApiFilter( NumericFilter::class, properties={ "userId" , "locationId" } )
 */
class Review
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               I D               -               -               -
    /**
     * The id of the review
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups( { "review:read" } )
     */
    private $id;


    //      -               -               -               L O C A T I O N   I D               -               -               -
    /**
     * The location the review belongs to
     *
     * @ORM\Column(type="integer")
     * @Groups( { "review:read", "review:write" } )
     */
    private $locationId;


    //      -               -               -               U S E R   I D               -               -               -
    /**
     * The user that wrote the review
     *
     * @ORM\Column(type="integer")
     * @Groups( { "review:read", "review:write" } )
     */
    private $userId;


    //      -               -               -               R A T I N G               -               -               -
    /**
     * The rating the user gave the location /5
     *
     * @ORM\Column(type="integer")
     * @Groups( { "review:read", "review:write" } )
     * @Assert\NotBlank()
     */
    private $rating;


    //      -               -               -               D E S C R I P T I O N               -               -               -
    /**
     * The text of the review
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=5,
     *     minMessage="Please put a minimum of 5 characters.",
     *     max=1000,
     *     maxMessage="Please do not exceed a 1000 characters."
     * )
     */
    private $description;


    //      -               -               -               C R E A T E D   A T               -               -               -
    /**
     * When the review was created
     *
     * @ORM\Column(type="datetime")
     * @Groups( { "review:write" } )
     */
    private $createdAt;


    //      -               -               -               I S   D E L E T E D               -               -               -
    /**
     * Whether or not the user has visually deleted the review from the website
     *
     * @ORM\Column(type="boolean")
     * @Groups( { "review:read", "review:write" } )
     */
    private $isDeleted = false;


    //      __________________________________________________________________________________
    //                                                                        M E T H O D S
    //      __________________________________________________________________________________

    //      -               -               -              C O N S T R U C T O R               -               -               -

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }


    //      -               -               -              getter ID               -               -               -
    /**
     * Get the id of the review
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    //      -               -               -              getter & setter LOCATION ID               -               -               -
    /**
     * Get the location the review belongs to
     */
    public function getLocationId(): ?int
    {
        return $this->locationId;
    }

    /**
     * Set the location the review belongs to
     */
    public function setLocationId(int $locationId): self
    {
        $this->locationId = $locationId;

        return $this;
    }


    //      -               -               -              getter & setter USER ID               -               -               -
    /**
     * Get the user that wrote the review
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * Set the user that wrote the review
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }


    //      -               -               -              getter & setter RATING               -               -               -
    /**
     * Get the rating the user gave the location /5
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * Set the rating the user gave the location /5
     */
    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }


    //      -               -               -              getter & setter DESCRIPTION               -               -               -
    /**
     * Get the text of the review
     *
     * @Groups( { "review:read" } )
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the text of the review
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the text of the review, transforming linebreaks to html
     *
     * @Groups( { "review:write" } )
     * @SerializedName( "description" )
     */
    public function setTextDescription(string $description): self
    {
        $this->description = nl2br( $description );

        return $this;
    }


    //      -               -               -              getter & setter CREATED AT               -               -               -
    /**
     *Get when the review was created
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * Get when the review was created, written as time ago
     *
     * @Groups( { "review:read" } )
     * @SerializedName( "createdAt" )
     */
    public function getCreatedAtAgo(): string
    {
        return Carbon::instance( $this->getCreatedAt() )->diffForHumans();
    }


    //      -               -               -              getter & setter IS DELETED               -               -               -
    /**
     * Get whether or not the review is visual on the website
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * Set whether or not the review is visual on the website
     */
    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}