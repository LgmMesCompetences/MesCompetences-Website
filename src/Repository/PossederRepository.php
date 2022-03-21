<?php

namespace App\Repository;

use App\Entity\Posseder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Func;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Posseder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posseder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posseder[]    findAll()
 * @method Posseder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PossederRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posseder::class);
    }

    // /**
    //  * @return Posseder[] Returns an array of Posseder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Posseder
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function searchUsersByCompetences_doctrine(String $competences)
    {
        $expr = $this->getEntityManager()->getExpressionBuilder();
        return $this->createQueryBuilder('p')
            ->select('DISTINCT p.user')
            ->where($expr->eq(
                'mcd_in_array(('.
                $this->createQueryBuilder('pos')
                    ->select("CONCAT('[',GROUP_CONCAT('\"',C.libelle,'\"'),']')")
                    ->join('pos.competence', 'C')
                    ->where($expr->eq('pos.user', 'p.user'))
                ->getDQL().
                '),'.
                '\':competences\''.
                ')',1)
            )
            ->setParameter('competences', $competences)
            ->getQuery()
            ->getSQL()
        ;
    }

    public function testInArray(String $competences)
    {
        $expr = $this->getEntityManager()->getExpressionBuilder();
        return $this->createQueryBuilder('p')
            ->select("mcd_in_array('[\"MainComp\", \"SubComp\"]',':competences')")
            ->setParameter('competences', $competences)
            ->getQuery()
            ->getResult()
        ;
    }

    public function testConcat(String $competences)
    {
        $expr = $this->getEntityManager()->getExpressionBuilder();
        return $this->createQueryBuilder('p')
            ->select("CONCAT('[',GROUP_CONCAT('\"',C.libelle, '\"'),']')")
            ->join('p.competence', 'C')
            ->getQuery()
            ->getResult()
        ;
    }

    public function searchUsersByCompetences_native(String $competences)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('App\Entity\User', 'u');
        $rsm->addFieldResult('u', 'user_id', 'id');

        $query = $this->getEntityManager()->createNativeQuery("SELECT DISTINCT p.user_id FROM posseder p WHERE mcd_in_array((SELECT CONCAT('[',GROUP_CONCAT('\"',C.libelle,'\"'),']') FROM posseder pos JOIN competence C ON pos.competence_id = C.id WHERE pos.user_id = p.user_id), :comp) = 1", $rsm);
        $query->setParameter(':comp', $competences);

        return $query->getResult();
    }
}
