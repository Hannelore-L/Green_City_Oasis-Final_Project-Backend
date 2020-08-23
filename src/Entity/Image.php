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
use App\Repository\ImageRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


//      __________________________________________________________________________________
//                                                                             C L A S S
//      __________________________________________________________________________________
/**
 * @ApiResource(
 *     collectionOperations={ "get", "post" },
 *     itemOperations={ "get", "put" },
 *     normalizationContext={ "groups" = { "image:read" }, "swagger_definition_name" = "Read" },
 *     denormalizationContext={ "groups" = { "image:write" }, "swagger_definition_name" = "Write" },
 * )
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @ApiFilter( BooleanFilter::class, properties={ "isDeleted" } )
 * @ApiFilter( SearchFilter::class, properties={
 *       "name" : "partial",
 *       "user" : "exact",
 *       "location" : "exact"
 * } )
 * @Vich\Uploadable()
 */
class Image
{
    //      __________________________________________________________________________________
    //                                                                     P R O P E R T I E S
    //      __________________________________________________________________________________

    //      -               -               -               I D               -               -               -
    /**
     * The id of the image
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups(  { "image:read", "location:read", "user:read" } )
     */
    private $id;


    //      -               -               -               U S E R   I D               -               -               -
    /**
     * The id of the user uploading the image
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     * @Groups(  { "image:read" } )
     */
    private $user;


//    //      -               -               -               L O C A T I O N   I D               -               -               -
    /**
     * The id of the location the image is of
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     * @Groups(  { "image:read" } )
     */
    private $location;


    //      -               -               -               N A M E               -               -               -
    /**
     * The name of the image
     *
     * @ORM\Column(type="string", length=255)
     * @Groups( { "image:read", "image:write", "location:read", "user:read" } )
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     minMessage="Please put a minimum of 2 characters.",
     *     max=140,
     *     maxMessage="Please do not exceed a 140 characters."
     * )
     */
    private $name;


    //      -               -               -               F I L E   N A M E               -               -               -
    /**
     * The name of the file of the image
     *
     * @ORM\Column(type="string", length=512)
     * @Groups( { "image:read", "image:write", "location:read", "user:read" } )
     * @var string
     */
    private $fileName;


    //      -               -               -               U P L O A D E D   A T               -               -               -
    /**
     * When the image was uploaded
     *
     * @ORM\Column(type="datetime")
     */
    private $uploadedAt;


    //      -               -               -               U P D A T E D   A T               -               -               -
    /**
     * When the image was uploaded
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    //      -               -               -               C O O R D I N A T E S               -               -               -
    /**
     * The coordinates of the image taken (estimate)
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups( { "image:read", "location:read", "user:read" } )
     */
    private $coordinates;


    //      -               -               -               I S   D E L E T E D               -               -               -
    /**
     * Whether or not the image is visual on the website
     * @ORM\Column(type="boolean")
     * @Groups( { "image:read", "image:write", "location:read", "user:read" } )
     */
    private $isDeleted = false;


      //      __________________________________________________________________________________
      //                                                                        V I C H
      //      __________________________________________________________________________________
      /**
       * @Vich\UploadableField( mapping="images", fileNameProperty="fileName" )
       * @var File
       */
      private $imageFile;


      //      __________________________________________________________________________________
     //                                                                        M E T H O D S
     //      __________________________________________________________________________________

    //      -               -               -              C O N S T R U C T O R               -               -               -

    public function __construct()
    {
        $this->uploadedAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }


    //      -               -               -              getter ID               -               -               -
    /**
     * Get the id of the image
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    //      -               -               -              getter & setter USER ID               -               -               -
    /**
     * Get the id of the user uploading the image
     */
    public function getUser(): ?user
    {
        return $this->user;
    }

    /**
     * Set the id of the user uploading the image
     */
    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }


    //      -               -               -              getter & setter LOCATION ID               -               -               -
    /**
     * Get the id of the location the image is of
     */
    public function getLocation(): ?location
    {
        return $this->location;
    }

    /**
     * Set the id of the location the image is of
     */
    public function setLocation(?location $location): self
    {
        $this->location = $location;

        return $this;
    }


    //      -               -               -              getter & setter NAME               -               -               -
    /**
     * Get the name of the image
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the name of the image
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    //      -               -               -              getter & setter FILE NAME               -               -               -
    /**
     * Get the name of the file of the image
     *
     * @return string
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * Set the name of the file of the image
     *
     * @param $fileName
     */
    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }


    //      -               -               -              getter & setter UPLOADED AT               -               -               -
    /**
     * Get then the image was uploaded
     */
    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploadedAt;
    }

    /**
     * Get then the image was uploaded, written as time ago
     *
     * @Groups( { "image:read", "location:read", "user:read" } )
     * @SerializedName( "uploadedAt" )
     */
    public function getUploadedAtAgo(): string
    {
        return Carbon::instance( $this->getUploadedAt() )->diffForHumans();
    }

      //      -               -               -              getter & setter UPDATED AT               -               -               -
      /**
       * Get then the image was updated
       *
       * @return mixed
       */
      public function getUpdatedAt()
      {
            return $this->updatedAt;
      }

      /**
       * Get then the image was updated, written as time ago
       *
       * @Groups( { "image:read", "location:read", "user:read" } )
       * @SerializedName( "updatedAt" )
       */
      public function getUpdatedAtAgo(): string
      {
            return Carbon::instance( $this->getUpdatedAt() )->diffForHumans();
      }



//      /**
//       * @param mixed $updatedAt
//       */
//      public function setUpdatedAt($updatedAt): void
//      {
//            $this->updatedAt = $updatedAt;
//      }


      //      -               -               -              getter & setter COORDINATES               -               -               -
    /**
     * Get the coordinates of the image taken (estimate)
     */
    public function getCoordinates(): ?string
    {
        return $this->coordinates;
    }

    /**
     * Set the coordinates of the image taken (estimate)
     */
    public function setCoordinates(string $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }


    //      -               -               -              getter & setter IS DELETED               -               -               -
    /**
     * Get whether or not the image is visual on the website
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * Set whether or not the image is visual on the website
     */
    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }


      //      __________________________________________________________________________________
      //                                                                        E A S Y   A D M I N
      //      __________________________________________________________________________________
      public function __toString()
      {
            return $this->name;
      }


      //      __________________________________________________________________________________
      //                                                                        V I C H
      //      __________________________________________________________________________________
      /**
       * @return File
       */
      public function getImageFile()
      {
            return $this->imageFile;
      }

      public function setImageFile(File $fileName = null)
      {
            $this->imageFile = $fileName;
            if ( $fileName ) {
                  $this->updatedAt = new \DateTime();
            }
      }
}