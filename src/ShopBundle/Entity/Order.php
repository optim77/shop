<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-31
 * Time: 20:06
 */

namespace ShopBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
*  @ORM\Entity(repositoryClass="ShopBundle\Repository\OrdersRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="User",
     *     inversedBy="order"
     * )
     *
     * @ORM\JoinColumn(
     *     name = "user",
     *     referencedColumnName = "id",
     *     onDelete = "SET NULL"
     * )
     *
     *
     */

    private $user;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $product;

    /**
     * @ORM\Column(type="boolean")
     */
    private $payed;

    /**
     * @ORM\Column(type="string")
     */
    private $bill;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Deliver",
     *     inversedBy="delivery"
     * )
     *
     * @ORM\JoinColumn(
     *     name = "delivery_id",
     *     referencedColumnName = "id",
     *     onDelete = "SET NULL"
     * )
     */
    private $delivery;

    /**
     * @ORM\Column(type="datetime")
     */
    private $purchaseDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completed;

//    /**
//     * @ORM\Column(type="boolean", nullable=true)
//     */
//    private $basket = null;

    /**
     * @ORM\Column(type="string", nullable=true, length=20)
     */
    private $orderId = null;

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
        $this->delivery = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set payed
     *
     * @param boolean $payed
     *
     * @return Order
     */
    public function setPayed($payed)
    {
        $this->payed = $payed;

        return $this;
    }

    /**
     * Get payed
     *
     * @return boolean
     */
    public function getPayed()
    {
        return $this->payed;
    }

    /**
     * Set bill
     *
     * @param string $bill
     *
     * @return Order
     */
    public function setBill($bill)
    {
        $this->bill = $bill;

        return $this;
    }

    /**
     * Get bill
     *
     * @return string
     */
    public function getBill()
    {
        return $this->bill;
    }

    /**
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
     *
     * @return Order
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Get purchaseDate
     *
     * @return \DateTime
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Set completed
     *
     * @param boolean $completed
     *
     * @return Order
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Add user
     *
     * @param \ShopBundle\Entity\User $user
     *
     * @return Order
     */
    public function addUser(\ShopBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \ShopBundle\Entity\User $user
     */
    public function removeUser(\ShopBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set user
     *
     * @param \ShopBundle\Entity\User $user
     *
     * @return Order
     */
    public function setUser(\ShopBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }



    /**
     * Set delivery
     *
     * @param \ShopBundle\Entity\Deliver $delivery
     *
     * @return Order
     */
    public function setDelivery(\ShopBundle\Entity\Deliver $delivery = null)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return \ShopBundle\Entity\Deliver
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set product
     *
     * @param array $product
     *
     * @return Order
     */
    public function setProduct($product)
    {
        $basketActualy = $this->getProduct();
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return array
     */
    public function getProduct()
    {
        return $this->product;
    }
}
