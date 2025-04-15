<?php
namespace App\Repository;
use App\Http\Model\Country;
use App\Http\Model\State;
use Illuminate\Support\Collection;

class CountryRepository {

    /**
     * Find a particular cms Details
     * @param array $condition
     * @return Country list
     */
    public function findAllCountryList() {
        $jobDetail = Country::all()->where('status',1)->toArray();
        return $jobDetail;
    }
   /**
     * Find a country list with states
     * @return array $country
     */
    public function findAllCountryListWithStates() {
        $countryList = Country::where('status',1)->with("states")->get()->toArray();
        return $countryList;
    }
    /**
     * Find a particular cms Details
     * @param array $condition
     * @return Country list
     */
    public function searchCountryList() {
        $jobDetail = Country::select("name")
        ->where('status',1)
        ->where("name","LIKE","%{$request->input('query')}%")
        ->get();
        return $jobDetail;
    }
    /**
     * Function to get country's states
     * @param integer $countryId
     * @param Response $statesForCountry
     */
    public function getStatesByCountry($countryId)
    {
        $statesForCountry = [];
        $states = State::where([["country_id","=",$countryId]])
                    ->get();
        if(!$states->isEmpty()){
            $statesForCountry = $states->toArray();
        }
        
        return $statesForCountry;     
    }
}

           