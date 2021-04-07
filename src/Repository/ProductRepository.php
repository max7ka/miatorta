<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }
    
     /**
      * @return Product[]
      */
    public function All()
    {
        return $this->createQueryBuilder('p')
            ->select('p','tk','count(im) as imagecount')
            ->leftJoin('p.TypeKind', 'tk')
            ->leftJoin('p.ProductImages', 'im')->groupBy('p.Id')
            ->getQuery()
            ->getScalarResult();
    }   
    
    //все где есть более трёх? фото
    public function AllLimitImages($ImageCountLimit)
    {
        return $this->createQueryBuilder('p')
            ->select('p','tk','count(im) as imagecount')
            ->having('count(im) >= :ImageCountLimit')->setParameter('ImageCountLimit', $ImageCountLimit)
            ->leftJoin('p.TypeKind', 'tk')
            ->leftJoin('p.ProductImages', 'im')->groupBy('p.Id')
            ->getQuery()
            ->getScalarResult();
    }     
    
    public function byId($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.Id = :id')->setParameter('id', $id)
            ->select('p','tk')//,'count(im)as imagecnt'
            ->leftJoin('p.TypeKind', 'tk')
            //->leftJoin('p.ProductImages', 'im')
            ->getQuery()
            ->getScalarResult();
    }
    public function byUrl($url)
    {
        return $this->createQueryBuilder('p')
            ->where('p.Url = :url')->setParameter('url', $url)
            ->select('p','tk')
            ->leftJoin('p.TypeKind', 'tk')
            ->getQuery()
            ->getScalarResult();
    }    
    public function byType($type)
    {
        return $this->createQueryBuilder('p')
            ->where('p.TypeKind = :type')->setParameter('type', $type)
            ->select('p','tk','count(im) as imagecount')
            ->leftJoin('p.TypeKind', 'tk')
            ->leftJoin('p.ProductImages', 'im')->groupBy('p.Id')
            ->getQuery()
            ->getScalarResult();
    }     

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('p')
            ->where('p.something = :value')->setParameter('value', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
