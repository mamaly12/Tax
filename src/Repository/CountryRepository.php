<?php

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Country|null find($id, $lockMode = null, $lockVersion = null)
 * @method Country|null findOneBy(array $criteria, array $orderBy = null)
 * @method Country[]    findAll()
 * @method Country[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Country::class);
    }


    /**
     * @param $name
     * @return Country
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addCountry($name)
    {
        $entityManager= $this->getEntityManager();
        $country = new Country();
        $country->setName($name);
        $entityManager->persist($country);
        $entityManager->flush();
        return $country;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCountriesCount()
    {
        $query= $this->createQueryBuilder('co')
            ->select('
                count(co.id)
            ')
            ->getQuery();
        $result=$query->getSingleScalarResult();
        return $result;
    }
}
