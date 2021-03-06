<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-20
 * Time: 21:06
 */

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Test\Fixture\Entity\Shop\Product;


/**
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\ProductsRepository")
 * @ORM\Table(name="products")
 * @ORM\HasLifecycleCallbacks
 */
class Products
{
    const UPLOAD_DIR = 'uploads/products/';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     *
     *
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=120, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amounts = null;


    /**
     * @ORM\Column(type="string", length=80)
     */
    private $images;

    /**
     * @var UploadedFile
     *
     * @Assert\Image(
     *     minWidth=50,
     *     maxWidth=15000,
     *     minHeight=50,
     *     maxHeight=15000,
     *     maxSize="15M",
     * )
     *
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $image2;

    /**
     * @var UploadedFile
     *
     * @Assert\Image(
     *     minWidth=50,
     *     maxWidth=15000,
     *     minHeight=50,
     *     maxHeight=15000,
     *     maxSize="15M",
     * )
     *
     */
    private $imageFile2;
    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $image3;

    /**
     * @var UploadedFile
     *
     * @Assert\Image(
     *     minWidth=50,
     *     maxWidth=15000,
     *     minHeight=50,
     *     maxHeight=15000,
     *     maxSize="15M",
     * )
     *
     */
    private $imageFile3;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateDate = null;

    private $imageTemp;

    private $imageTemp2;

    private $imageTemp3;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Category",
     *     inversedBy="products"
     * )
     *
     * @ORM\JoinColumn(
     *     name = "category_id",
     *     referencedColumnName = "id",
     *     onDelete = "SET NULL"
     * )
     *
     */
    private $category;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Brand",
     *     inversedBy="products"
     * )
     *
     * @ORM\JoinColumn(
     *     name = "brand_id",
     *     referencedColumnName = "id",
     *     onDelete = "SET NULL"
     * )
     *
     */
    private $brand;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishDate = null;


    /**
     * @ORM\OneToMany(
     *     targetEntity="Opinion",
     *     mappedBy="product"
     * )
     *
     * @ORM\OrderBy({"createData" = "DESC"})
     */
    private $opinion;

    /**
     * @ORM\Column(type="integer")
     */
    private $prize;

//    /**
//     * @ORM\OneToMany(
//     *     targetEntity="Order",
//     *     mappedBy="product"
//     * )
//     */
//    protected $order;




    /**
     * Constructor
     */
    public function __construct()
    {
        $this->opinion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->order = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }


    public function setImageFile(UploadedFile $imageFile)
    {
        $this->imageFile = $imageFile;
        $this->updateDate = new \DateTime();
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getImageFile2()
    {
        return $this->imageFile2;
    }

    public function setImageFile2($imageFile2)
    {
        $this->imageFile2 = $imageFile2;
        $this->updateDate = new \DateTime();
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getImageFile3()
    {
        return $this->imageFile3;
    }

    public function setImageFile3($imageFile3)
    {
        $this->imageFile3 = $imageFile3;
        $this->updateDate = new \DateTime();
        return $this;
    }



    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Products
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Products
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Products
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set images
     *
     * @param string $images
     *
     * @return Products
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImage2()
    {
        return Products::UPLOAD_DIR.$this->image2;
    }

    /**
     * Set images
     *
     * @param string $image2
     *
     * @return Products
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;
        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImage3()
    {
        return Products::UPLOAD_DIR.$this->image3;
    }

    /**
     * Set images
     *
     * @param string $image3
     *
     * @return Products
     */
    public function setImage3($image3)
    {
        $this->image3 = $image3;
        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImages()
    {
        return Products::UPLOAD_DIR.$this->images;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Products
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return Products
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set publishDate
     *
     * @param \DateTime $publishDate
     *
     * @return Products
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get publishDate
     *
     * @return \DateTime
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set category
     *
     * @param \ShopBundle\Entity\Category $category
     *
     * @return Products
     */
    public function setCategory(\ShopBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ShopBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set brand
     *
     * @param \ShopBundle\Entity\Brand $brand
     *
     * @return Products
     */
    public function setBrand(\ShopBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \ShopBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add opinion
     *
     * @param \ShopBundle\Entity\Opinion $opinion
     *
     * @return Products
     */
    public function addOpinion(\ShopBundle\Entity\Opinion $opinion)
    {
        $this->opinion[] = $opinion;

        return $this;
    }

    /**
     * Remove opinion
     *
     * @param \ShopBundle\Entity\Opinion $opinion
     */
    public function removeOpinion(\ShopBundle\Entity\Opinion $opinion)
    {
        $this->opinion->removeElement($opinion);
    }

    /**
     * Get opinion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpinion()
    {
        return $this->opinion;
    }

    /**
     * Set prize
     *
     * @param integer $prize
     *
     * @return Products
     */
    public function setPrize($prize)
    {
        $this->prize = $prize;

        return $this;
    }

    /**
     * Get prize
     *
     * @return integer
     */
    public function getPrize()
    {
        return $this->prize;
    }


    /**
     * @return mixed
     */
    public function getAmounts()
    {
        return $this->amounts;
    }

    /**
     * @param mixed $amounts
     */
    public function setAmounts($amounts)
    {
        $this->amounts = $amounts;
    }

    /**
     * Add order
     *
     * @param \ShopBundle\Entity\Products $order
     *
     * @return Products
     */
    public function addOrder(\ShopBundle\Entity\Products $order)
    {
        $this->order[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \ShopBundle\Entity\Products $order
     */
    public function removeOrder(\ShopBundle\Entity\Products $order)
    {
        $this->order->removeElement($order);
    }

    /**
     * Get order
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preSave(){
        if(null != $this->getImageFile()){
            if(null !== $this->images){
                $this->imageTemp = $this->images;
            }
            $imageName = sha1(uniqid(null,true));
            $this->images = $imageName.'.'.$this->getImageFile()->guessExtension();
        }
        if (null != $this->getImageFile2()){
            if(null !== $this->image2){
                $this->imageTemp2 = $this->image2;
            }
            $imageName = sha1(uniqid(null,true));
            $this->image2 = $imageName.'.'.$this->getImageFile2()->guessExtension();
        }
        if (null != $this->getImageFile3()){
            if(null !== $this->image3){
                $this->imageTemp3 = $this->image3;
            }
            $imageName = sha1(uniqid(null,true));
            $this->image3 = $imageName.'.'.$this->getImageFile3()->guessExtension();
        }

    }

    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function postSave(){
        if(null !== $this->getImageFile()){
            $this->getImageFile()->move($this->getUploadRootDir(), $this->images);
            unset($this->imageFile);

            if(null !== $this->imageTemp){
                unlink($this->getUploadRootDir().$this->imageTemp);
                unset($this->imageTemp);
            }

        }

        if(null !== $this->getImageFile2()){
            $this->getImageFile2()->move($this->getUploadRootDir(), $this->image2);
            if (null !== $this->imageTemp2){
                unlink($this->getUploadRootDir().$this->imageTemp2);
                unset($this->imageTemp2);
            }
        }
        if(null !== $this->getImageFile3()){
            $this->getImageFile3()->move($this->getUploadRootDir(), $this->image3);
            if(null !== $this->imageTemp3){
                unlink($this->getUploadRootDir().$this->imageTemp3);
                unset($this->imageTemp3);
            }
        }
    }


    protected function getUploadRootDir(){
        return __DIR__.'/../../../web/'.Products::UPLOAD_DIR;
    }

}
