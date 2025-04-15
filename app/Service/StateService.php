<?php
namespace App\Service;
use App\Repository\StateRepository;
use Illuminate\Support\Facades\Auth;

class StateService {
    
    protected $stateRepo;

    /**
     * @param StateRepository $stateRepo reference to state
     */
    public function __construct(
        StateRepository $stateRepo
    ) {
        $this->stateRepo = $stateRepo;
       
    }

    /** 
     * Get state list
     * @param array $id
    */
    public function getStateList(){
        return $this->stateRepo->findAllStateList();
    }

     /** 
     * Get state list
     * @param array $id
    */
    public function getStateById($id=''){
        return $this->stateRepo->getStateListById($id);
    }
     /** 
     * Get city list
     * @param array $id
    */
    public function getCityById($id=''){
        return $this->stateRepo->getCityListById($id);
    }
    public function getCityDetailsId($id)
    {
        return $this->stateRepo->getCityDetailsId($id);
    }

     /** 
     * Get city list
     * @param array $id
    */
    public function getCityByIdIn($request){
        return $this->stateRepo->getCityByIdIn($request);
    }
    /* Get city list
    * @param array $id
   */
   public function getAllSelectedCity($stateArr){
       return $this->stateRepo->getAllSelectedCity($stateArr);
   }
    
}