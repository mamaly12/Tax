<?php


namespace App\Controller;

use App\Entity\Country;
use App\Entity\County;
use App\Entity\State;
use App\Form\CountryForm;
use App\Form\CountyForm;
use App\Form\StateForm;
use App\Service\TaxService;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TaxController extends AbstractController
{

    /**
     * @var TaxService
     */
    private $taxService;

    /**
     * TaxController constructor.
     * @param TaxService $taxService
     */
    public function __construct(TaxService $taxService)
    {
        $this->taxService = $taxService;
    }

    /**
     * @Route("/country/list", name="home_url", methods={"GET"})
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(){
        $statistics=$this->taxService->getStatistics();
        $canAddCountry = $this->taxService->canAddCountry();
        $canAddState = $this->taxService->canAddState();
        return $this->render('countries/index.html.twig',array('statistics'=>$statistics,'canAddCountry'=>$canAddCountry,'canAddState'=>$canAddState));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addCountry(Request $request)
    {
        $canAddCountry = $this->taxService->canAddCountry();
        if(!$canAddCountry)
        {
            throw $this->createAccessDeniedException('No more country can be added');
        }
        $country = new Country();
        $form = $this->createForm(CountryForm::class, $country);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $name = $form->get('name')->getData();
            $this->taxService->addCountry($name, $country);
            return new RedirectResponse($this->generateUrl('home_url'));
        }
        return $this->render('countries/country_add.html.twig',
            array('form'=>$form->createView()));
    }

    /**
     * @param $countryId
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("country/{countryId}/state/add", name="add_state", methods={"POST","GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addState($countryId,Request $request)
    {
        $state = new State();
        $form = $this->createForm(StateForm::class, $state);
        $form->handleRequest($request);
        $country = $this->taxService->findCountryById($countryId);
        $states=$this->taxService->findAllStatesByCountry($country);
        $canAddState = $this->taxService->canAddState();
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $name = $form->get('name')->getData();
            $this->taxService->addState($name, $country);
            return new RedirectResponse($this->generateUrl('add_state',array('countryId'=>$countryId)));
        }
        return $this->render('countries/state_add.html.twig',
            array('form'=>$form->createView(),'states'=>$states,'country'=>$country->getName(),'canAddState'=>$canAddState));
    }

    /**
     * @param $stateId
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route("state/{stateId}/county/add", name="add_county", methods={"POST","GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addCounty($stateId,Request $request)
    {
        $county = new County();
        $form = $this->createForm(CountyForm::class, $county);
        $form->handleRequest($request);
        $state = $this->taxService->findStateById($stateId);
        $counties=$this->taxService->findAllCountiesByState($state);
        if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $name = $form->get('name')->getData();
                $taxRate = $form->get('taxRate')->getData();
                $income = $form->get('income')->getData();
                $this->taxService->addCounty($state, $name,$taxRate,$income );
                return new RedirectResponse($this->generateUrl('add_county',array('stateId'=>$stateId)));
        }
        return $this->render('countries/county_add.html.twig',
            array('form'=>$form->createView(),'counties'=>$counties,'state'=>$state->getName(),'country'=>$state->getCountry()->getName()));
    }

}