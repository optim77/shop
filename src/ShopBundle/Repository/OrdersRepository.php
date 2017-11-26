<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-31
 * Time: 20:07
 */

namespace ShopBundle\Repository;
use Doctrine\ORM\EntityRepository;

class OrdersRepository extends EntityRepository
{

    public function getQueryBuilder(array $params = array()){
        $qb = $this->createQueryBuilder('u')
            ->select('u, o, d')
            ->leftJoin('u.user','o')
            ->leftJoin('u.delivery','d');

        if (!empty($params['search'])){
            $search = '%'.$params['search'].'%';
            $qb->andWhere('o.id LIKE :search OR u.orderId LIKE :search')
                ->setParameter('search',$search);
        }
        if(!empty($params['when'])){
            $currentTime = new \DateTime();
            dump($currentTime);
            if ($params['when'] != $currentTime ){

            }
        }
        $qb->orderBy('u.id','DESC');

        return $qb->getQuery()->getResult();

    }

    public function getStackOrder(){
        $qb = $this->createQueryBuilder('u')
            ->select('u, o, p, d')
            ->leftJoin('u.user','o')
            ->leftJoin('u.product','p')
            ->leftJoin('u.delivery','d');
    }

    public function getOrders($idUser){
        $qb = $this->createQueryBuilder('u')
            ->select('u, o,  d')
            ->leftJoin('u.user','o')
            ->leftJoin('u.product','p')
            ->leftJoin('u.delivery','d');

        $qb
            ->andWhere('o.id = :idUser')
            ->setParameter('idUser',$idUser);
        $qb
            ->andWhere('u.completed = 0');

        $qb
            ->andWhere('u.basket = 1');


        return $qb->getQuery()->getResult();
    }


    public function deleteFromBasket($id,$user){
        $qb = $this->createQueryBuilder('o');
        $qb->delete()
            ->where('o.product = :id')
            ->setParameter('id',$id);
        $qb->andWhere('o.user = :user')
            ->setParameter('user',$user);
        $qb->andWhere('o.basket = 1');

        return $qb->getQuery()->getResult();
    }

    public function finalize($idUser){
        $id = substr(hexdec(uniqid()),2,10);
        $orderId = uniqid(true,true);
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.user = :id')
            ->setParameter('id',$idUser)
            ->andWhere('o.basket = 1');


        return $qb->getQuery()->getResult();
    }


    public function getOrder($idUser,$orderId){
        $qb = $this->createQueryBuilder('o')
            ->leftJoin('o.user','u')
            ->leftJoin('o.delivery','d')
            ->select('o,u,d')
            ->where('o.user = :idUser')
            ->setParameter('idUser', $idUser)
            ->andWhere('o.orderId = :orderId')
            ->setParameter('orderId', $orderId);

        return $qb->getQuery()->getResult();
    }

}