<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-22
 * Time: 17:14
 */

namespace ShopBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

use ShopBundle\Entity\User;

class UserRepository extends EntityRepository
{

    public function getQueryBuilder(array $params = array()){
        $qb = $this->createQueryBuilder('u')
            ->select('u');
        dump($qb->getQuery()->getResult());
        if (!empty($params['search'])){
            $search = '%'.$params['search'].'%';
            $qb->andWhere('u.name LIKE :search OR u.surname LIKE :search OR u.email LIKE :search OR u.phone LIKE :search ')
                ->setParameter('search',$search);
        }


        return $qb;

    }


    public function getSuchUser($id){
        $qb = $this->createQueryBuilder('u')
            ->select('o,u,p')
            ->where('o.user = :id')
            ->setParameter('id',$id)
            ->leftJoin('u.order','o')
            ->leftJoin('o.product','p');
        return $qb->getQuery()->getResult();
    }

    public function addToBasket($item){
        $qb = $this->createQueryBuilder('p');
        $qb->update('p.basket');

    }

}