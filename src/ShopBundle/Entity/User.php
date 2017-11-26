<?php


namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\UserRepository")
 * @UniqueEntity(fields={"email"})
 * @UniqueEntity(fields={"username"})
 * @ORM\HasLifecycleCallbacks
 */
class User implements AdvancedUserInterface, \Serializable
{


    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     *
     * @Assert\NotBlank
     *
     * @Assert\Length(
     *     min=5,
     *     max=20,
     *     groups= {"Register","Login"}
     *     )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(groups = {"SetData"} )
     * @Assert\Length(
     *     min=2,
     *     max=20,
     *     groups = {"SetData"}
     * )
     */

    private $name = null;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\NotBlank(groups = {"SetData"})
     * @Assert\Length(
     *     min=2,
     *     max=30,
     *     groups = {"Register","SetData"}
     * )
     *
     */
    private $surname = null;

    /**
     * @ORM\Column(type="string", length=120, unique=true)
     *
     * @Assert\NotBlank(groups={"Login", "Register"})
     *
     * @Assert\Length(
     *     min=10,
     *     max=100,
     *     groups = {"Login","Register"}
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @Assert\NotBlank(groups = {"Register", "Login"})
     *
     * @Assert\Length(min=6,max=4096,groups = {"Register", "Login"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", nullable=true, length=2)
     *
     * @Assert\NotBlank(groups={"SetData"})
     */
    private $country = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"SetData"})
     *
     */
    private $city = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"SetData"})
     *
     */
    private $zipCode = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"SetData"})
     */
    private $street = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"SetData"})
     */
    private $number = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotBlank(groups={"SetData"})
     */
    private $region = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Assert\NotBlank(groups={"SetData"})
     */
    private $phone = null;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $basket = null;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $bought = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private $joinDate;

    /**
     * @ORM\Column(name="account_non_expired", type="boolean")
     */
    private $accountNonExpired = true;

    /**
     * @ORM\Column(name="account_non_locked", type="boolean")
     */
    private $accountNonLocked = true;

    /**
     * @ORM\Column(name="credentials_non_expired", type="boolean")
     */
    private $credentialsNonExpired = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled = false;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(name="action_token", type="string", length=20, nullable=true)
     */
    private $actionToken;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Order",
     *     mappedBy="user"
     * )
     */
    private $order;


    public function __construct()
    {
        $this->order = new \Doctrine\Common\Collections\ArrayCollection();
        return $this->joinDate = new \DateTime();
    }

    public function isAccountNonExpired(){
        return $this->accountNonExpired;
    }

    public function isAccountNonLocked(){
        return $this->accountNonLocked;
    }

    public function isCredentialsNonExpired(){
        return $this->credentialsNonExpired;
    }

    public function isEnabled(){
        return $this->enabled;
    }

    public function getRoles() {
        if(empty($this->roles)){
            return array('ROLE_USER');
        }
        return $this->roles;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getSalt(){
        return null;
    }

    public function getUsername(){
        return $this->username;
    }

    public function eraseCredentials(){
        $this->plainPassword = null;
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
     * @return User
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }


    public function getSurname()
    {
        return $this->surname;
    }


    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set country
     *
     * @param integer $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return integer
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;
    }


    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return User
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return User
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return User
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return User
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set basket
     *
     * @param string $basket
     *
     * @return User
     */
    public function setBasket($basket)
    {

        $this->basket = $basket;

        return $this;
    }

    /**
     * Get basket
     *
     * @return string
     */
    public function getBasket()
    {
            return $this->basket;

    }

    /**
     * Set bought
     *
     * @param string $bought
     *
     * @return User
     */
    public function setBought($bought)
    {
        $this->bought = $bought;

        return $this;
    }

    /**
     * Get bought
     *
     * @return string
     */
    public function getBought()
    {
        return $this->bought;
    }

    /**
     * Set joinDate
     *
     * @param \DateTime $joinDate
     *
     * @return User
     */
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    /**
     * Get joinDate
     *
     * @return \DateTime
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * Set accountNonExpired
     *
     * @param boolean $accountNonExpired
     *
     * @return User
     */
    public function setAccountNonExpired($accountNonExpired)
    {
        $this->accountNonExpired = $accountNonExpired;

        return $this;
    }

    /**
     * Get accountNonExpired
     *
     * @return boolean
     */
    public function getAccountNonExpired()
    {
        return $this->accountNonExpired;
    }

    /**
     * Set accountNonLocked
     *
     * @param boolean $accountNonLocked
     *
     * @return User
     */
    public function setAccountNonLocked($accountNonLocked)
    {
        $this->accountNonLocked = $accountNonLocked;

        return $this;
    }

    /**
     * Get accountNonLocked
     *
     * @return boolean
     */
    public function getAccountNonLocked()
    {
        return $this->accountNonLocked;
    }

    /**
     * Set credentialsNonExpired
     *
     * @param boolean $credentialsNonExpired
     *
     * @return User
     */
    public function setCredentialsNonExpired($credentialsNonExpired)
    {
        $this->credentialsNonExpired = $credentialsNonExpired;

        return $this;
    }

    /**
     * Get credentialsNonExpired
     *
     * @return boolean
     */
    public function getCredentialsNonExpired()
    {
        return $this->credentialsNonExpired;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set actionToken
     *
     * @param string $actionToken
     *
     * @return User
     */
    public function setActionToken($actionToken)
    {
        $this->actionToken = $actionToken;

        return $this;
    }

    /**
     * Get actionToken
     *
     * @return string
     */
    public function getActionToken()
    {
        return $this->actionToken;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function serialize() {
        return serialize(array(
            $this->id,
            $this->username,
            $this->email,
            $this->name,
            $this->surname,
            $this->password
        ));
    }

    public function unserialize($serialized) {
        list(
            $this->id,
            $this->username,
            $this->email,
            $this->name,
            $this->surname,
            $this->password
            ) = unserialize($serialized);
    }

}
