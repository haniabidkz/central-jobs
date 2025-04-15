<?php
namespace App\Service\Company;
use App\Repository\Company\CompanyReportRepository;
use Illuminate\Support\Facades\Auth;

class CompanyReportService {
    
    protected $companyReportRepo;

    /**
     * @param CompanyReportRepo $candidateRepo reference to CompanyReportRepo
     * 
     */
    public function __construct(
        CompanyReportRepository $companyReportRepo
    ){
        $this->companyReportRepo = $companyReportRepo;
    }

    /** 
     * Get All Company List
    */
    public function fetchList($companyId='') {
        return $this->companyReportRepo->get($companyId);
    }
    /** 
     * Get All Company List
    */
    public function fetchReportedList() {
        return $this->companyReportRepo->getList();
    }

    public function fetchListArray($companyId='') {
        return $this->companyReportRepo->fetchListArray($companyId);
    }

}