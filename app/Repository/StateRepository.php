<?php
namespace App\Repository;
use App\Http\Model\State;
use App\Http\Model\City;
use Illuminate\Support\Collection;

class StateRepository {

    /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function findAllStateList() {
        $jobDetail = State::all();
        return $jobDetail;
    }

     /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getStateListById($id='') {
        $states = State::where('country_id',$id)
                        ->orderBy("name","ASC")->get();
        return $states;
    }

     /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getCityListById($id='') {
        $states = City::where('state_id',$id)
                        ->orderBy("name","ASC")->get();
        return $states;
    }

    /**
     * Find a city details
     * @param array $condition
     * @return State list
     */
    public function getCityDetailsId($id='') {
        $city = City::where('id',$id)
                        ->first();
        return $city;
    }

     /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getCityByIdIn($request) {
        $stateIds = $request->all();
        $states = City::whereIn('state_id',$stateIds['state_id'])
                        ->orderBy("name","ASC")->get();
        return $states;
    }

     /**
     * Find a all state list
     * @param array $condition
     * @return State list
     */
    public function getAllSelectedCity($stateArr) {
        $states = City::whereIn('state_id',$stateArr)
                        ->where('name','!=','Wien')
                        ->orderBy("name","ASC")->get();
        return $states;
    }

}