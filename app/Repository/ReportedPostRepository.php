<?php
namespace App\Repository;
use App\Http\Model\JobPost;
use App\Http\Model\State;
use App\Http\Model\Country;
use App\Http\Model\JobApplied;
use App\Http\Model\Upload;
use App\Http\Model\PostCategory;
use App\Http\Model\Skill;
use App\Http\Model\selectedSkill;
use App\Http\Model\ReportedPost;
use App\Http\Model\CommonComment;
use Illuminate\Support\Collection;
use DB;

class ReportedPostRepository {

    /**
     * Get post list
     * @return post
     */
    public function get($conditions='',$with) {
        $reportedPost = ReportedPost::where($conditions)->groupBy('type_id')->select('type_id', DB::raw('count(*) as total'))->with([$with])->orderBy("id","DESC")->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $reportedPost;
    }

    /**
     * Get post list
     * @return post
     */
    public function getAll($conditions='',$with) {
        $reportedPost = ReportedPost::where($conditions)->groupBy('type_id')->select('type_id', DB::raw('count(*) as total'))->with([$with])->orderBy("id","DESC")->get();
        return $reportedPost;
    }

    public function details($id=''){
        $report = ReportedPost::where('type_id',$id)->with('reporterUser');
        $report = $report->orderBy("id","ASC")->get()->toArray();
        return $report;
    }

    public function viewDetails($id) {
        $post = JobPost::where('id',$id)
                ->with(['upload','user','report'])
                ->first();
        return $post;
    }

    public function reportedPostAbuse($request){
        $postId = $request['postId'];
        $post = JobPost::where('id',$postId)->update(['status' => 0]);
        $report = ReportedPost::where('type_id',$postId)->update(['status' => 1]);
        return 'success'; 
    }

    public function reportedPostIgnore($request){
        $postId = $request['postId'];
        $report = ReportedPost::where('type_id',$postId)->update(['status' => 2]);
        return 'success'; 
    }

    public function viewCommentDetails($id){
        $comment = CommonComment::where('id',$id)
                ->with(['user','report','post'])
                ->first();
        return $comment;
    }

    public function reportedCommentAbuse($request){
        $commentId = $request['commentId'];
        $post = CommonComment::where('id',$commentId)->update(['status' => 0]);
        $report = ReportedPost::where('type_id',$commentId)->update(['status' => 1]);
        return 'success'; 
    }

    public function reportedCommentIgnore($request){
        $commentId = $request['commentId'];
        $report = ReportedPost::where('type_id',$commentId)->update(['status' => 2]);
        return 'success'; 
    }
}