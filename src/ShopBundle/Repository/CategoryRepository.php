<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-24
 * Time: 13:54
 */

namespace ShopBundle\Repository;
use Doctrine\ORM\EntityRepository;
use ShopBundle\Entity\Category;

class CategoryRepository extends  EntityRepository
{



    public function getQueryBuilder(array $params = array()){
        $qb = $this->createQueryBuilder('c')
            ->select('c');

        if (!empty($params['search'])){
            $search = '%'.$params['search'].'%';
            $qb->andWhere('c.name LIKE :search ')
                ->setParameter('search',$search);
        }

        return $qb;
    }

    public function getArray(){
        return $this->createQueryBuilder('c')
            ->select('c.id, c.name')
            ->getQuery()
            ->getArrayResult();
    }



}