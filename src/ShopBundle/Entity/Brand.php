<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-20
 * Time: 21:35
 */

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\BrandRepository")
 * @ORM\Table(name="brands")
 * @ORM\HasLifecycleCallbacks
 */
class Brand
{
    const UPLOAD_DIR = 'uploads/Brands/';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=120, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $image;

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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateDate = null;

    private $imageTemp;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Products",
     *     mappedBy="brand"
     * )
     */
    protected $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Brand
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
     * @return Brand
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
     * Set description
     *
     * @param string $description
     *
     * @return Brand
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
     * Set products
     *
     * @param \ShopBundle\Entity\Products $products
     *
     * @return Brand
     */
    public function setProducts(\ShopBundle\Entity\Products $products = null)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return \ShopBundle\Entity\Products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Brand
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return Brand::UPLOAD_DIR.$this->image;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Brand
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
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preSave(){
        if(null != $this->getImageFile()){
            if(null !== $this->image){
                $this->imageTemp = $this->image;
            }

            $imageName = sha1(uniqid(null,true));
            $this->image = $imageName.'.'.$this->getImageFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function postSave(){
        if(null !== $this->getImageFile()){
            $this->getImageFile()->move($this->getUploadRootDir(), $this->image);
            unset($this->imageFile);

            if(null !== $this->imageTemp){
                //unlink($this->getUploadRootDir().$this->imageTemp);
                unset($this->imageTemp);
            }

        }
    }


    protected function getUploadRootDir(){
        return __DIR__.'/../../../web/'.Brand::UPLOAD_DIR;
    }

    /**
     * Add product
     *
     * @param \ShopBundle\Entity\Products $product
     *
     * @return Brand
     */
    public function addProduct(\ShopBundle\Entity\Products $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \ShopBundle\Entity\Products $product
     */
    public function removeProduct(\ShopBundle\Entity\Products $product)
    {
        $this->products->removeElement($product);
    }
}
