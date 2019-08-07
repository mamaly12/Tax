<?php

namespace App\Repository;

use App\Entity\State;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method State|null find($id, $lockMode = null, $lockVersion = null)
 * @method State|null findOneBy(array $criteria, array $orderBy = null)
 * @method State[]    findAll()
 * @method State[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StateRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, State::class);
    }

    /**
     * @param $name
     * @param $country
     * @return State
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addState($name,$country)
    {
        $entityManager= $this->getEntityManager();
        $state = new State();
        $state->setName($name);
        $state->setCountry($country);
        $entityManager->persist($state);
        $entityManager->flush();
        return $state;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findStatesCount()
    {
        $query= $this->createQueryBuilder('st')
            ->select('
                count(st.id)
            ')
            ->getQuery();
        $result=$query->getSingleScalarResult();
        return $result;
    }
}
