<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-20
 * Time: 21:41
 */

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="opinions")
 */
class Opinion
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Products",
     *     inversedBy="opinion"
     * )
     *
     * @ORM\JoinColumn(
     *     name="postId",
     *     referencedColumnName="id",
     *     nullable = false
     * )
     *
     */
    private $product;

    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createData;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     *
     * @Assert\Length(max=1000)
     */
    private $opinion;

}