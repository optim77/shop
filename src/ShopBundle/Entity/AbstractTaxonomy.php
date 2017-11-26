<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-21
 * Time: 20:05
 */

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\MappedSuperclass
 */
class AbstractTaxonomy
{

    private $id;

    private $name;



}