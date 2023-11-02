<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query;
use Doctrine\ORM\Query as ORMQuery;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /*
    * @return Property[] Returns an array of Property Objects
    */
    public function findAllVisible(): array
    {
        return $this->CreateQueryVisible()
            ->getQuery()
            ->getResult();
    }

    /*
    * @return ORMquery
    */
    public function findQueryAllVisible(PropertySearch $search): ORMQuery
    {
        $query = $this->CreateQueryVisible();
        if ($search->getSurfaceMin()) {

            $query = $query->andWhere('p.surface >= :surfaceMin')
                ->setParameter('surfaceMin', $search->getSurfaceMin());
        }
        if ($search->getBudgetMax()) {
            $query = $query->andWhere('p.price <= :budgetMax')
                ->setParameter('budgetMax', $search->getBudgetMax());
        }
        if ($search->getOptions()->count() > 0) {
            foreach ($search->getOptions() as $k => $option) {
                $query = $query->andWhere(":option$k MEMBER OF p.options")
                    ->setParameter(":option$k", $option);
            }
        }
        return  $query
            ->getQuery();
    }

    /*
    * @return Query 
    */

    public function CreateQueryVisible(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }

    //    /**
    //     * @return Property[] Returns an array of Property objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Property
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
