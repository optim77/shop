<?php
/**
 * Created by PhpStorm.
 * User: NASA
 * Date: 2017-10-21
 * Time: 17:00
 */

namespace ShopBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductsRepository extends EntityRepository
{

    public function getQueryBuilder(array $params = array()){

        $qb = $this->createQueryBuilder('p')
            ->select('p,c,b')
            ->leftJoin('p.category','c')
            ->leftJoin('p.brand','b');
        if(!empty($params['status'])){
            if('published' == $params['status']){
                $qb->where('p.publishDate <= :currentDate AND p.publishDate IS NOT NULL')
                    ->setParameter('currentDate',new \DateTime());
            }elseif ('unpublished' == $params['status']){
                $qb->where('p.publishDate > :currentDate OR p.publishDate IS NULL')
                    ->setParameter('currentDate',new \DateTime());
            }
        }

        if (!empty($params['search'])){
            $search = '%'.$params['search'].'%';
            $qb->andWhere('p.name LIKE :search ')
                ->setParameter('search',$search);
        }

        if (!empty($params['categoryId'])){
            $qb->andWhere('c.id = :categoryId')
                ->setParameter('categoryId',$params['categoryId']);
        }

        if (!empty($params['brandId'])){
            $qb->andWhere('b.id = :brandId')
                ->setParameter('brandId',$params['brandId']);
        }

        if(!empty($params['orderBy'])){
            $orderDir = !empty($params['orderDir']) ? $params['orderDir'] : NULL;
            $qb->orderBy($params['orderBy'],$params['orderDir']);
        }
        return $qb;

    }

    public function getLastsPosts(){
        $qb = $this->createQueryBuilder(array('status' => 'published'));
        return $qb;
    }

    public function getProduct($slug){
        $qb = $this->getQueryBuilder(array('status' => 'published'));

        $qb->andWhere('p.slug = :slug')
            ->setParameter('slug',$slug);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getBrandProducts($BrandSlugName){
        $qb = $this->getQueryBuilder(array('status' => 'published'));

        $qb->andWhere('b.slug = :slug')
            ->setParameter('slug',$BrandSlugName);

//        $qb->select('b.id')
//            ->andwhere('b.slug = :slug')
//            ->setParameter('slug',$BrandSlugName);
//        dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }

    public function getCategoryProducts($CategorySlugName){
        $qb = $this->getQueryBuilder(array('status' => 'published'));

        $qb->andWhere('c.slug =:slug')
            ->setParameter('slug',$CategorySlugName);

        return $qb->getQuery()->getResult();
    }

    public function getTypes(){
        $brands = $this->getQueryBuilder(array())
            ->select('b.id');

        $category = $this->getQueryBuilder(array())
            ->select('c.slug');

        dump($category->getQuery()->getResult());

        return $brands->getQuery()->getResult();
    }

    public function getContext(){
        $qb = $this->createQueryBuilder('p')
            ->select('p, c, b')
            ->leftJoin('p.category','c')
            ->leftJoin('p.brands','b');

        return $qb->getQuery()->getResult();
    }

    public function editProduct($slug){
        $qb = $this->createQueryBuilder('p')
            ->select('p,c,b')
            ->leftJoin('p.category','c')
            ->leftJoin('p.brand','b');
        $qb->andWhere('p.slug = :slug')
            ->setParameter('slug',$slug);

        return $qb->getQuery()->getResult();
    }

    public function getPropose(){
        $qb = $this->getQueryBuilder(array('status' => 'published'));
        $qb->setMaxResults(5);
        $qb->orderBy('p.id','DESC');
        return $qb->getQuery()->getArrayResult();
    }

    public function MainPageProducts($amount){
        $qb = $this->getQueryBuilder(array('status' => 'published'));

       return $qb->addSelect('RAND() as HIDDEN rand')
            ->addOrderBy('rand')
            ->setMaxResults($amount)
            ->getQuery()
            ->getResult();

    }

    public function getBasketProducts(array $items){
        $qb = $this->createQueryBuilder('p');
        $qb->select('p');
        $qb->where('p.id = :key');
        foreach ($items as $key){
                $qb->setParameter('key',$key);
            $results[] = $qb->getQuery()->getResult();
        }
        return isset($results) ? $results : null;
    }

    public function getOrderProducts(array $items){
        $qb = $this->createQueryBuilder('p');
        $qb->select('p');
        $qb->where('p.id = :key');
        dump($items);// orders list
        foreach ($items as $key){

                //dump($item);
                $qb->setParameter('key',$key);
                $results[] = $qb->getQuery()->getResult();


        }
        dump($results);

        return isset($results) ? $results : null;
    }

}