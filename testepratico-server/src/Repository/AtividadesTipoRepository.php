<?php

namespace App\Repository;

use App\Entity\AtividadesTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AtividadesTipo|null find($id, $lockMode = null, $lockVersion = null)
 * @method AtividadesTipo|null findOneBy(array $criteria, array $orderBy = null)
 * @method AtividadesTipo[]    findAll()
 * @method AtividadesTipo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtividadesTipoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AtividadesTipo::class);
    }

    // /**
    //  * @return AtividadesTipo[] Returns an array of AtividadesTipo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AtividadesTipo
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function transform(AtividadeTipo $atividade)
    {
        return [
                'id'    => (int) $atividade->getId(),
                'title' => (string) $atividade->getTitle(),
        ];
    }

    public function transformAll()
    {
        $atividades = $this->findAll();
        $atividadesArray = [];

        foreach ($atividades as $atividade) {
            $atividadesArray[] = $this->transform($atividade);
        }

        return $atividadesArray;
    }
}
