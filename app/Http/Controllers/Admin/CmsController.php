<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\CmsService;
use App\Service\UploadService;
use App\Http\Requests\PageRequest;
use App\Http\Requests\PageContentsReference;
use DB;
class CmsController extends Controller
{
    protected $cmsServices;
    protected $uploadService;
    public function __construct(CmsService $cmsService,UploadService $uploadService)
    {   
        $this->cmsServices = $cmsService;
        $this->uploadService = $uploadService;
    }
    public function index(Request $request)
    {
        $pages = $this->cmsServices->getAllPages($request);
        $search = ['page_name' => $request->input('page_name',"") ,"status" => $request->input('status',"")];
        $activeModule = "cmsPages";
        $pageTitle = 'Page List';
        return view('Admin.Cms.list', compact("pages","search","activeModule","pageTitle"));
    }
    /**
     * Function to add page new data
     * @return view
     */
    public function add()
    {
        $details = [];
        $activeModule = "cmsPages";
        $pageTitle = 'Page Add';
        return view('Admin.Cms.add-edit', compact("details","activeModule","pageTitle"));
    }
    /**
     * Function to store page new data
     * @return Void
     */
    public function store(PageRequest $request)
    {
        $data = $this->cmsServices->create($request);
        if($data == 'error'){
            $request->session()->flash('message-error', "Page name already exsist." );
        }else{
            $request->session()->flash('message-success', 'Page added successfully.');
        }
        
        return redirect('admin/page-list');
    }
    /**
     * Function to delete cms page 
     * @param integer $id
     * @return Void
     */
    public function destroy($id)
    {     
        $this->cmsServices->destroy($id);
        request()->session()->flash('message-success', 'Page deleted successfully.');
        return redirect('admin/page-list');
    }
    /**
     * Function to update cms 
     * @param string $id
     * @return @view
     */
    public function update($id)
    {
        $id = decrypt($id);
        $details = $this->cmsServices->getPage($id);   
        $activeModule = "cmsPages";
        $pageTitle = 'Page Edit';
        return view('Admin.Cms.add-edit', compact("details","activeModule","pageTitle"));
    }
    /**
     * Function to update data info page
     * @return Void
     */
    public function updatePageInfo(PageRequest $request)
    {       
        try {
                $status = $this->cmsServices->updatePageInfo($request,$request->input('id'));
                if($status == 'true'){
                    request()->session()->flash('message-success', 'Page updated successfully.');
                }else if($status == 'error'){
                    request()->session()->flash('message-error', "Page name already exsist." );
                }
        } catch (Exception $e) {
                request()->session()->flash('message-error', 'Page updation failed.');
        }
        return redirect('admin/page-list');
    }
    /**
     * Function to add content refference for the page
     * @return view
     */
    public function pageContentRef($id)
    {         
        $encryptedId = $id;
        $id = decrypt($id);
        DB::enableQueryLog();
        $pagesContents = $this->cmsServices->getAllPageContents($id); 
        $page = $this->cmsServices->getPage($id);
        $quries = DB::getQueryLog();
       
        // if($pagesContents->isEmpty()){
        //     request()->session()->flash('message-error', "Page doesn't exist failed.");
        //     return redirect('admin/page-list');
        // }    
        
        $search = ['content_ref' => request()->input('content_ref',''),"status" => request()->input('status','')];
        $activeModule = "cmsPages";
        $pageTitle = 'Page Content Reference';
        return view('Admin.Cms.list-content-reference', compact("pagesContents","search","activeModule","encryptedId","pageTitle",'page'));
    }
     /**
     * Function to delete cms page 
     * @param integer $id
     * @return Void
     */
    public function destroyPageContent($id)
    {     
        $this->cmsServices->destroyPageContent($id);
        request()->session()->flash('message-success', 'Page deleted successfully.');
        return redirect('admin/page-list');
    }
    /**
     * Function to add page reference 
     * @return View
     */
    public function addPageReference($id)
    {            
        $encryptedId = $id;
        $id = decrypt($id);//page id        
        $details = [];
        $activeModule = "cmsPages";
        $pageTitle = 'Page Content Reference Add';
        return view('Admin.Cms.add-edit-page-ref', compact("details","activeModule","encryptedId","id","pageTitle"));
    }

    /**
     * Function to store page reference data
     * @return Void
     */
    public function storePageReference($id,PageContentsReference $pageReqRef)
    {
        $encryptedId = $id;          
        try {
            $status = $this->cmsServices->createPageContentRef($pageReqRef->all());
            if($status == 'error'){
                request()->session()->flash('message-error', 'Page reference content already exist.');
            }else{
                request()->session()->flash('message-success', 'Page reference added successfully.');
            }
        } catch (Exception $e) {
            request()->session()->flash('message-error', 'Page reference failed to add.');
        }
        return redirect("admin/page-content-reference/$encryptedId");
    }
    /**
     * Function to delete page reference
     * @return Void
     */
    public function deletePageReference($pageRefId)
    {        
        $pageContentRefInfo = $this->cmsServices->getPageContentRef($pageRefId);        
        if(empty($pageContentRefInfo)){
            request()->session()->flash('message-error', "Page doesn't exist failed.");
            return redirect('admin/page-list');
        }
        try {
            $status = $this->cmsServices->destroyPageContent($pageContentRefInfo["id"]);
            if($status){
                $status = $this->cmsServices->destroyPageContentText($pageContentRefInfo["id"]);
            }
            request()->session()->flash('message-success', 'Page reference deleted successfully.');
        } catch (Exception $e) {
            request()->session()->flash('message-error', 'Page reference failed to add.');            
        }
        $encryptedId = encrypt($pageContentRefInfo['page_id']);
        return redirect("admin/page-content-reference/$encryptedId");
    }
    /**
     * Function to update page content reference 
     * @param string $id
     * @return @view
     */
    public function updatePageContentRef($id)
    {
        
        $id = decrypt($id);        
        $details = $this->cmsServices->getPageContentRef($id);
        if(empty($details)){
            request()->session()->flash('message-error', "Page doesn't exist failed.");
            return redirect('admin/page-list');
        }
        $encryptedId = encrypt($details['page_id']);
        $activeModule = "cmsPages";
        $pageTitle = 'Page Content Reference Edit';
        return view('Admin.Cms.add-edit-page-ref', compact("details","activeModule","encryptedId","id","pageTitle"));
    }
    /**
     * Function to update data info page
     * @return Void
     */
    public function updatePageContRefInfo($id,PageContentsReference $pageReqRef)
    {               
        try {
            $status = $this->cmsServices->updatePageContentInfo($pageReqRef->all(),$pageReqRef->input('id'));
            if($status == 'true'){
                request()->session()->flash('message-success', 'Page content reference updated successfully.');
            }elseif($status == 'error') {
               request()->session()->flash('message-error', 'Page content refrence already exist.');
            }
        } catch (Exception $e) {
                request()->session()->flash('message-error', 'Page content refrence updation failed.');
                return redirect('admin/page-list');
        }
        //$encryptedId = encrypt($pageReqRef['page_id']);
        return redirect("admin/page-content-reference/$id");
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/04/2020 
    @FunctionFor: Page content text list
    */
    public function getPageContentText($id){
        $id = decrypt($id);  
        $details = $this->cmsServices->getPageContentRef($id);
        $idRf = $details['page_id'];
        $textList = $this->cmsServices->getPageContentText($id);
        if(count($textList) == 0){
            $activeModule = "cmsPages";
            $pageTitle = 'Page Content Text Add';
            return view('Admin.Cms.add-page-content-text', compact("activeModule","id","idRf","pageTitle",'details'));
        }else{
            $activeModule = "cmsPages";
            $pageTitle = 'Page Content Text';
            return view('Admin.Cms.list-page-content-text', compact("textList","activeModule","id","idRf","pageTitle",'details'));
        }
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/04/2020
    @FunctionFor: Page content text add
    */
    public function addPageContentText(Request $request){
        $data = $request->all();
        $details = $this->cmsServices->getPageContentRef($data['page_contents_id']);
        try {
            $status = $this->cmsServices->createPageContentText($request->all());
            request()->session()->flash('message-success', 'Page text added successfully.');
        } catch (Exception $e) {
            request()->session()->flash('message-error', 'Page text failed to add.');
            return redirect("admin/page-content-reference/".encrypt($details['page_id']));
        }
        return redirect("admin/get-page-content-text/".encrypt($data['page_contents_id']));
        
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/04/2020
    @FunctionFor: Page content text edit
    */
    public function editPageContentText($id){
        $id = decrypt($id);  
        $text = $this->cmsServices->editPageContentText($id);

        $activeModule = "cmsPages";
        $pageTitle = 'Page Content Text Edit';
        return view('Admin.Cms.edit-page-content-text', compact("text","activeModule","id","pageTitle"));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/04/2020
    @FunctionFor: Page content text edit post
    */

    public function editPageContentTextPost(Request $request){
        $data = $request->all();
        try {
            $status = $this->cmsServices->updatePageContentText($request->all());
            request()->session()->flash('message-success', 'Page text updated successfully.');
        } catch (Exception $e) {
            request()->session()->flash('message-error', 'Page text failed to update.');
        }
        return redirect("admin/get-page-content-text/".encrypt($data['page_contents_id']));
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 08/04/2020
    @FunctionFor: Banner image delete
    */
     public function bannerImageDelete(Request $request){
        $data = $request->all();
        $retundata = $this->uploadService->destroy($data['imgId']);
        if($retundata){
            $return = $this->cmsServices->updatePage($data['pageId']);
        }
        echo 1; exit;
     }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Content reference status change
    */
    public function pageChangeStatus(Request $request){
        $data = $request->all(); 
        $cmsContentRef = $this->cmsServices->updatePageStatus($data);
        if($cmsContentRef == true){
            request()->session()->flash('message-success', "Status changed successfully" );
            return 1;
        }else{
            request()->session()->flash('message-error', "Something went wrong, please try again." );
            return 0;
        }
        
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: Content reference status change
    */
    public function contentRefChangeStatus(Request $request){
        $data = $request->all(); 
        $cmsContentRef = $this->cmsServices->updateContentRefStatus($data);
        if($cmsContentRef == true){
            request()->session()->flash('message-success', "Status changed successfully" );
            return 1;
        }else{
            request()->session()->flash('message-error', "Something went wrong, please try again." );
            return 0;
        }
        
    }

}

