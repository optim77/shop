<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-29
 * Time: 23:22
 */

namespace ShopBundle\Repository;
use Doctrine\ORM\EntityRepository;
use ShopBundle\Entity\Brand;

class BrandRepository extends EntityRepository
{
    public function getQueryBuilder(array $params = array()){
        $qb = $this->createQueryBuilder('b')
            ->select('b');

        if (!empty($params['search'])){
            $search = '%'.$params['search'].'%';
            $qb->andWhere('b.name LIKE :search ')
                ->setParameter('search',$search);
        }

        return $qb;

    }

    public function getArray(){
        return $this->createQueryBuilder('b')
            ->select('b.id, b.name')
            ->getQuery()
            ->getArrayResult();
    }

}