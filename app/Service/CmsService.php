<?php

namespace App\Service;

use App\Http\Model\ContactUs;
use App\Repository\CommonRepository;
use App\Http\Model\Page;
use App\Http\Model\PageContents;
use App\Http\Model\PageContentText;
use App\Http\Model\Upload;
use Cookie;
use App\Http\Model\User;
use Carbon\Carbon;

class CmsService
{

    protected $pageRepository;
    protected $pageContents;
    protected $pageContentText;
    protected $contactUsRepository;
    public function __construct(Page $page, PageContents $pageContents, PageContentText $pageContentText, Upload $upload, ContactUs $contactUsRepository)
    {
        $this->pageRepository = new CommonRepository($page);
        $this->pageContents   = new CommonRepository($pageContents);
        $this->pageContentText   = new CommonRepository($pageContentText);
        $this->uploadRepository   = new CommonRepository($upload);
        $this->contactUsRepository = new CommonRepository($contactUsRepository);
    }

    public function getAllPages($request)
    {
        $condition = [];
        if ($request->input('page_name')) {
            $condition[] = ['page_name', "LIKE", "%" . $request->input('page_name') . "%"];
        }
        if ($request->input('status')) {
            $status = $request->input('status');
            if ($status == 2) {
                $status = 0;
            }
            $condition[] = ['status', $status];
        }
        $limit = env('ADMIN_PAGINATION_LIMIT');
        $relations = ['upload', 'pageContents'];
        $pages = $this->pageRepository->getWith($condition, $limit, $relations);
        return $pages;
    }
    public function getAllPageContents($pageId)
    {

        $condition[] = ['page_id', $pageId];
        if (request()->input('content_ref', false) != false) {
            $condition[] = ['content_ref', "LIKE", "%" . request()->input('content_ref') . "%"];
        }
        if (request()->input('status', false) != false) {
            $status = request()->input('status');
            if ($status == 2) {
                $status = 0;
            }
            $condition[] = ['status', $status];
        }
        $limit = env('ADMIN_PAGINATION_LIMIT');
        $pages = $this->pageContents->getWith($condition, $limit, 'pageInfo');
        return $pages;
    }
    public function create($request)
    {
        $data = [];
        $chkname = $this->chkUniqueName($request['page_name']);
        if ($chkname != NULL) {
            return 'error';
        } else {
            //banner image upload
            $dataForUpload = [];
            if ($file   =   $request->file('banner_image')) {
                $name  =   time() . '.' . $file->getClientOriginalExtension();
                $target_path   =   public_path() . '/upload/banner_image';
                if ($file->move($target_path, $name)) {
                    $dataForUpload['name'] = $name;
                    $dataForUpload['type'] = 'cms';
                    $dataForUpload['uploads_type'] = 'image';
                    $dataForUpload['user_id'] = 1;
                    $dataForUpload['description'] = 'cms page banner image';
                    $dataForUpload['location'] = '/upload/banner_image/' . $name;
                    $upload = $this->uploadRepository->create($dataForUpload);
                    $data['banner_image_upload_id'] = $upload->id;
                }
            }
            $request = $request->all();
            $data['page_name'] = $request['page_name'];
            $data['status'] = $request['status'];
            $pageData = $this->pageRepository->create($data);
            if (!empty($pageData) && !empty($dataForUpload)) {
                $updateData = $this->uploadRepository->update(['type_id' => $pageData->id], $upload->id);
            }
            return $pageData;
        }
    }
    public function destroy($id)
    {
        return $this->pageRepository->delete($id);
    }
    public function getPage($id)
    {
        $condition = [['id', $id]];
        $relations = 'upload';
        return $this->pageRepository->showWith($condition, $relations);
    }

    public function updatePageInfo($request, $id)
    {
        $chkname = $this->chkUniqueName($request['page_name'], $id);
        if ($chkname != null) {
            return 'error';
        } else {
            $data = [];
            //banner image upload
            $dataForUpload = [];
            if ($file   =   $request->file('banner_image')) {
                $prevData = $this->getPage($id);
                if ($prevData['upload'] != '') {
                    $name  =   time() . '.' . $file->getClientOriginalExtension();
                    $target_path   =   public_path() . '/upload/banner_image';
                    if ($file->move($target_path, $name)) {
                        $dataForUpload['name'] = $name;
                        $dataForUpload['location'] = '/upload/banner_image/' . $name;
                        $upload = $this->uploadRepository->update($dataForUpload, $prevData['banner_image_upload_id']);
                        if (file_exists(public_path() . '/upload/banner_image/' . $prevData['upload']['name'])) {
                            unlink(public_path() . '/upload/banner_image/' . $prevData['upload']['name']);
                        }
                    }
                } else {
                    $name  =   time() . '.' . $file->getClientOriginalExtension();
                    $target_path   =   public_path() . '/upload/banner_image';
                    if ($file->move($target_path, $name)) {
                        $dataForUpload['name'] = $name;
                        $dataForUpload['type'] = 'cms';
                        $dataForUpload['uploads_type'] = 'image';
                        $dataForUpload['user_id'] = 1;
                        $dataForUpload['description'] = 'cms page banner image';
                        $dataForUpload['location'] = '/upload/banner_image/' . $name;
                        $dataForUpload['type_id'] = $id;
                        $upload = $this->uploadRepository->create($dataForUpload);
                        $data['banner_image_upload_id'] = $upload->id;
                    }
                }
            }
            $request = $request->all();
            $data['page_name'] = $request['page_name'];
            $data['status'] = $request['status'];
            $pageData = $this->pageRepository->update($data, $id);
            return $pageData;
        }
    }
    public function getPageContentRef($id)
    {
        return $this->pageContents->show($id);
    }
    public function destroyPageContent($id)
    {
        return $this->pageContents->delete($id);
    }
    public function createPageContentRef($request)
    {

        $chkname = $this->chkUniqueReferenceName($request['content_ref'], $request['page_id']);
        if ($chkname != NULL) {
            return 'error';
        } else {
            return  $this->pageContents->create($request);
        }
    }
    public function updatePageContentInfo(array $data, $id)
    {
        $chkname = $this->chkUniqueReferenceName($data['content_ref'], $data['page_id'], $id);
        if ($chkname != NULL) {
            return 'error';
        } else {
            unset($data['page_id']);
            return $this->pageContents->update($data, $id);
        }
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/04/2020
    @FunctionFor: Page content text list
    */
    public function getPageContentText($id)
    {
        $limit = 4; // for 4 different languages
        $relations = 'pageContent';
        $condition = [];
        $condition[] = ['page_contents_id', $id];
        return $this->pageContentText->getWith($condition, $limit, $relations);
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/04/2020
    @FunctionFor: Page content text add
    */
    public function createPageContentText($request)
    {
        if ($request) {
            $data = [
                ['type' => 1, 'language_type' => 'English', 'page_contents_id' => $request['page_contents_id'], 'text' => html_entity_decode($request['text_english']), 'status' => 1],
                //['type'=>1, 'language_type'=> 'French','page_contents_id'=> $request['page_contents_id'], 'text'=> html_entity_decode($request['text_french']),'status'=>1],
                ['type' => 1, 'language_type' => 'German', 'page_contents_id' => $request['page_contents_id'], 'text' => html_entity_decode($request['text_french']), 'status' => 1],
                ['type' => 1, 'language_type' => 'Portuguese', 'page_contents_id' => $request['page_contents_id'], 'text' => html_entity_decode($request['text_portuguese']), 'status' => 1]
            ];
            return  $this->pageContentText->multipleRowInsert($data);
            // NOTE: I am using insart function insted of create for multiple row insert. so created_at and updated_at do not insert default value. at db i have set current_timestamp by default.
        }
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/04/2020
    @FunctionFor: Page content text edit show
    */
    public function editPageContentText($id)
    {
        $condition  = [['id', $id]];
        $relations = 'pageContent';
        return  $this->pageContentText->showWith($condition, $relations);
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 07/04/2020
    @FunctionFor: Page content text edit
    */
    public function updatePageContentText($request)
    {
        $id = $request['id'];
        return  $this->pageContentText->update($request, $id);
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 08/04/2020
    @FunctionFor: Page update
    */
    public function updatePage($id)
    {
        $update['banner_image_upload_id'] = 0;
        return  $this->pageRepository->update($update, $id);
    }

    public function chkUniqueName($name = '', $id = '')
    {
        if ($id != '') {
            $condition = [["id", '!=', $id], ["page_name", $name]];
        } else {
            $condition = [["page_name", $name]];
        }
        $data = $this->pageRepository->findOne($condition);
        return $data;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 08/04/2020
    @FunctionFor: Page content text delete
    */
    public function destroyPageContentText($id)
    {
        $condition = [['page_contents_id', $id]];
        return $this->pageContentText->deleteByCondition($condition);
    }


    public function chkUniqueReferenceName($name = '', $pageId = '', $id = '')
    {
        if ($id != '') {
            $condition = [["id", '!=', $id], ["content_ref", $name], ['page_id', $pageId]];
        } else {
            $condition = [["content_ref", $name], ['page_id', $pageId]];
        }
        $data = $this->pageContents->findOne($condition);
        return $data;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: page content update or change status
    */
    public function updateContentRefStatus($request)
    {
        $id = $request['id'];
        $subscription = $this->pageContents->update($request, $id);
        return $subscription;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 18/03/2020
    @FunctionFor: page update or change status
    */
    public function updatePageStatus($request)
    {
        $id = $request['id'];
        $subscription = $this->pageRepository->update($request, $id);
        return $subscription;
    }
    public function setLanguage($request)
    {
        $lang = $request['language'];
        Cookie::queue('language', $lang, 30);
    }

    public function getCmsData($id)
    {
        $lang = Cookie::get('locale');
        //dd($lang);
        if ($lang == 'fr') {
            $language = 'French';
        } else if ($lang == 'en') {
            $language = 'English';
        } else if ($lang == 'de') {
            $language = 'German';
        } else {
            //$language = 'Portuguese';
            $language = 'German';
        }
        $condition = [['id', '=', $id]];
        $relations = ['pageContent'];
        $pageData = PageContentText::where([['language_type', '=', $language]])->with($relations);
        $pageData = $pageData->whereHas('pageContent.pageInfo', function ($q) use ($condition) {
            $q->where($condition);
        });
        return $pageData->orderBy("id", "DESC")->get()->toArray();
    }
    public function getCmsDataForHome($id)
    {
        $lang = Cookie::get('locale');
        if ($lang == 'fr') {
            $language = 'French';
        } else if ($lang == 'de') {
            $language = 'German';
        } else if ($lang == 'en') {
            $language = 'English';
        } else {
            //$language = 'Portuguese';
            $language = 'German';
        }
        $condition = [['id', '=', $id]];
        $relations = ['pageContent'];
        $pageData = PageContentText::where([['language_type', '=', $language]])->with($relations);
        $pageData = $pageData->whereHas('pageContent.pageInfo', function ($q) use ($condition) {
            $q->where($condition);
        });
        return $pageData->orderBy("id", "ASC")->get()->toArray();
    }

    public function getAdminData()
    {
        $adminData = User::where('id', 1)->get()->first();
        return $adminData;
    }

    public function saveContactUsData($data)
    {
        $data['ip_address'] = self::getIpAddress();
        ContactUs::where('created_at', '<', Carbon::today())->delete();
        $this->contactUsRepository->create($data);
    }

    public function checkRestriction()
    {
        $ipadress = self::getIpAddress();
        $restriction = ContactUs::where('ip_address', $ipadress)->whereDate('created_at', Carbon::today())->count();
        if ($restriction >= 2) {
            return true;
        } else {
            return false;
        }
    }

    public static function getIpAddress()
    {
        if ((isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) || (isset($_SERVER['HTTP_X_SUCURI_CLIENTIP']) && !empty($_SERVER['HTTP_X_SUCURI_CLIENTIP']))) {
            $ip_address = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : $_SERVER['HTTP_X_SUCURI_CLIENTIP'];
        }
        //whether ip is from proxy
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }
        return $ip_address;
    }
}
