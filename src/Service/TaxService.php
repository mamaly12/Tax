<?php


namespace App\Service;
use App\Entity\Country;
use App\Entity\County;
use App\Entity\State;
use \App\Repository\CountyRepository;
use \App\Repository\CountryRepository;
use \App\Repository\StateRepository;
use Doctrine\ORM\EntityNotFoundException;
use http\Exception\InvalidArgumentException;


final class TaxService
{
    const COUNTRY_LIMIT = 1;

    const STATE_LIMIT = 5;

    /**
     * @var CountyRepository
     */
    private $countyDao;

    /**
     * @var CountryRepository
     */
    private $countryDao;

    /**
     * @var StateRepository
     */
    private $stateDao;


    /**
     * RaceHorseService constructor.
     * @param CountryRepository $countryDao
     * @param StateRepository $stateDao
     * @param CountyRepository $countyDao
     */
    public function __construct(CountryRepository $countryDao, StateRepository $stateDao,CountyRepository $countyDao)
    {
        $this->countryDao=$countryDao;
        $this->stateDao=$stateDao;
        $this->countyDao=$countyDao;
    }

    /**
     * @return bool
     */
    public function canAddCountry()
    {
        $noCurrentCountry= $this->findCountriesCount();
        if($noCurrentCountry>=self::COUNTRY_LIMIT)
        {
            return false;
        }
        return true;
    }

    /**
     * @param $name
     * @return Country|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addCountry($name): ?Country
    {
        //TODO return good error
       if(!$this->canAddCountry())
       {
           return null;
       }
        $countryDto = $this->countryDao->addCountry($name);
        return $countryDto;

    }


    /**
     * @return bool
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function canAddState()
    {
        $noCurrentStates= $this->findStatesCount();
        if($noCurrentStates>=self::STATE_LIMIT)
        {
            return false;
        }
        return true;
    }

    /**
     * @param $name
     * @param  Country $country
     * @return State|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addState($name,$country): ?State
    {
        //TODO return good error
        if(!$this->canAddState())
        {
            return null;
        }
        $stateDto = $this->stateDao->addState($name,$country);
        return $stateDto;

    }

    /**
     * @param State $state
     * @param $name
     * @param $taxRate
     * @param $income
     * @return County|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addCounty($state,$name,$taxRate,$income): ?County
    {
        $countyDto = $this->countyDao->addCounty($state,$name,$taxRate,$income);
        return $countyDto;

    }

    /**
     * @return County[]
     */
    public function findAllCountries()
    {
        $counties = $this->countryDao->findAll();
        return $counties;
    }

    /**
     * @param $countryId
     * @return mixed
     */
    public function findStateStatisticsByCountryId($countryId)
    {
        return $this->countyDao->findStateStatisticsByCountryId($countryId);
    }

    /**
     * @param $countryId
     * @return mixed
     */
    public function findCountryStatisticsByCountryId($countryId)
    {
        return $this->countyDao->findCountryStatisticsByCountryId($countryId);
    }


    /**
     * @return array
     */
    public function getStatistics()
    {
        $countries=$this->findAllCountries();
        $countryStatistics= array();
        foreach ($countries as $country)
        {
            $countryStatistics[$country->getId()]['countryInfo']=$this->findCountryStatisticsByCountryId($country->getId());
            $countryStatistics[$country->getId()]['statesInfo']=$this->findStateStatisticsByCountryId($country->getId());
        }
        return $countryStatistics;
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findCountriesCount()
    {
        return $this->countryDao->findCountriesCount();
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findStatesCount()
    {
        return $this->stateDao->findStatesCount();
    }

    /**
     * @param $countryId
     * @return Country|null
     */
    public function findCountryById($countryId)
    {
        return $this->countryDao->find($countryId);
    }

    /**
     * @param $stateId
     * @return State|null
     */
    public function findStateById($stateId)
    {
        return $this->stateDao->find($stateId);
    }

    /**
     * @param $state
     * @return County[]
     */
    public function findAllCountiesByState($state)
    {
        return $this->countyDao->findBy(array('state' => $state));
    }

    /**
     * @param $country
     * @return State[]
     */
    public function findAllStatesByCountry($country)
    {
        return $this->stateDao->findBy(array('country' => $country));
    }
}