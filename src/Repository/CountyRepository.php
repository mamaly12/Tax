<?php

namespace App\Repository;

use App\Entity\County;
use App\Entity\State;
use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method County|null find($id, $lockMode = null, $lockVersion = null)
 * @method County|null findOneBy(array $criteria, array $orderBy = null)
 * @method County[]    findAll()
 * @method County[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, County::class);
    }

    /**
     * @param $state
     * @param $name
     * @param $taxRate
     * @param $income
     * @return County County
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addCounty($state,$name,$taxRate,$income)
    {
        $entityManager= $this->getEntityManager();
        $county = new County();
        $county->setState($state);
        $county->setName($name);
        $county->setTaxRate($taxRate);
        $county->setIncome($income);
        $entityManager->persist($county);
        $entityManager->flush();
        return $county;
    }

    public function findStateStatisticsByCountryId($countryId)
    {

        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
        SELECT  co.name AS country, st.name AS state
        ,SUM(cu.income *(cu.tax_rate/100)) AS overall_tax_per_state
        ,AVG(cu.income *(cu.tax_rate/100)) AS average_tax_per_state
        ,AVG(cu.tax_rate) AS average_county_tax_rate_per_state
        ,st.id AS state_id
        FROM county cu
        RIGHT JOIN state st ON cu.state_id=st.id
        RIGHT JOIN country co ON st.country_id=co.id 
        WHERE country_id=:countryId  
        GROUP BY st.id
        ORDER BY st.id
        ");
        $statement->bindValue('countryId', (int)$countryId);
        $statement->execute();
        $results = $statement->fetchAll();
        // returns an array of User objects
        return $results;
    }

    public function findCountryStatisticsByCountryId($countryId)
    {

        $em = $this->getEntityManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT co.name as country
		,SUM(cu.income *(cu.tax_rate/100)) AS overall_tax_amount
        ,SUM(cu.tax_rate) AS overall_tax_rate 
        ,co.id AS country_id
        FROM country AS co
        LEFT JOIN state st ON st.country_id=co.id
        LEFT JOIN county cu ON st.country_id=cu.id 
        WHERE co.id=1  
        GROUP BY co.id
        ORDER BY co.id     
        ");
        $statement->bindValue('countryId', (int)$countryId);
        $statement->execute();
        $results = $statement->fetch();
        // returns an array of User objects
        return $results;
    }
}
