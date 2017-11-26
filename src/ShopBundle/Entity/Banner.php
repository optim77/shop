<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-11-04
 * Time: 18:08
 */

namespace ShopBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\BannerRepository")
 * @ORM\Table(name="banners")
 * @ORM\HasLifecycleCallbacks
 */
class Banner
{

    const UPLOAD_DIR = 'uploads/banners/';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $redirect;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Banner
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Banner
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
     * Set image
     *
     * @param string $image
     *
     * @return Banner
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
        return Banner::UPLOAD_DIR.$this->image;
    }

    /**
     * Set redirect
     *
     * @param string $redirect
     *
     * @return Banner
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;

        return $this;
    }

    /**
     * Get redirect
     *
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Banner
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
                unlink($this->getUploadRootDir().$this->imageTemp);
                unset($this->imageTemp);
            }

        }
    }


    protected function getUploadRootDir(){
        return __DIR__.'/../../../web/'.Banner::UPLOAD_DIR;
    }


}
