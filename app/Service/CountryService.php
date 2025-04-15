<?php
namespace App\Service;
use App\Repository\CountryRepository;
use Illuminate\Support\Facades\Auth;
use Response;
class CountryService {
    
    protected $countryRepo;
    
    /**
     * @param CountryRepository $userRepo reference to userRepo
     * 
     */
    public function __construct(
        CountryRepository $countryRepo
    ) {
        $this->countryRepo = $countryRepo;
    }

    /** 
     * Get country list
     * @param array $id
    */
    public function findAllCountryListWithStates(){
        return $this->countryRepo->findAllCountryListWithStates();
    }
   /** 
     * Get country list
     * @param array $id
    */
    public function getCountryList(){
        return $this->countryRepo->findAllCountryList();
    }
    /** 
     * Get country list
     * @param array $id
    */
    public function countryWithsearch(){
        return $this->countryRepo->searchCountryList();
    }
    /**
     * Function to get country states
     * @param integer $countryId
     * @return json 
     */
    public function getStatesByCountry($countryId)
    {   
         return $this->countryRepo->getStatesByCountry($countryId);
    }

    
   
}