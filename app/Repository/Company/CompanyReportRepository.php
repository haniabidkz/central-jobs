<?php
namespace App\Repository\Company;
use App\Http\Model\User;
use App\Http\Model\ReportedPost;
use Illuminate\Support\Facades\DB;

class CompanyReportRepository {
   
    /**
     * Get company's report list
     * @return reports
     */
    public function get($companyId = '') {
        $userId = $companyId;
        $condi = [['id',$userId]];
        $reports = User::where($condi)->with(['report']);
        $reports = $reports->get()->toArray();
        return $reports;
    }
    /**
     * Get company's report list
     * @return reports
     */
    public function getList() {
    	$searchTerm = 0;
        $reports = User::where('user_type',3)->with('report');
        $reports = $reports->whereHas('report', function($query) use($searchTerm){
                $query->where('status',$searchTerm)
               		   ->where('type','company');
        });
        $reports = $reports->orderBy("id","DESC")->get()->toArray();
        return $reports;
    }
     public function fetchListArray($companyId){
        $userId = $companyId;
        $condi = [['type_id',$userId],['status',0],['type','company']];
        $reports = ReportedPost::where($condi)->with(['reporterUser']);
        $reports = $reports->orderBy("id","DESC")->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $reports;
     }

}