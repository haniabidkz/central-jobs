<?php 

namespace App\Service;
use App\Repository\CommonRepository;
use App\Http\Model\MasterScreeningQuestion;
use App\Http\Model\ScreeningAnswerOption;
use App\Http\Model\MultiLanguageScreeningQuestion;
use App\Http\Model\User;
use App\Http\Model\ScreeningUserAnswer;
use Auth;

class ScreeningQuestionService {
    
    protected $scrningQuestionRepo;
    protected $answerOptionRepo;
    protected $multiLanguageRepo;
    protected $userRepo;
    protected $screeningUserAnswer;

    public function __construct(
        MasterScreeningQuestion $scrningQuestionRepo, 
        ScreeningAnswerOption $answerOptionRepo, 
        MultiLanguageScreeningQuestion $multiLanguageRepo,User $userRepo,ScreeningUserAnswer $screeningUserAnswer)
    {
        $this->scrningQuestionRepo = new CommonRepository($scrningQuestionRepo);
        $this->answerOptionRepo = new CommonRepository($answerOptionRepo);
        $this->multiLanguageRepo = new CommonRepository($multiLanguageRepo);
        $this->userRepo = new CommonRepository($userRepo);
        $this->screeningUserAnswer = new CommonRepository($screeningUserAnswer);
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 09/04/2020
    @FunctionFor: Question all list
    */
    public function getAllList()
    {   
        $condition = [];
        $relations = ['multiLangualQuestion','answerOptions'];
        $limit = env('ADMIN_PAGINATION_LIMIT');
        $question = $this->scrningQuestionRepo->getWith($condition,$limit,$relations); 
        return $question;
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/04/2020
    @FunctionFor: Question find one
    */
    public function details($id){
        $condition = [ ["id",$id] ];
        $relations = ['multiLangualQuestion','answerOptions'];
        return $this->scrningQuestionRepo->showWith($condition,$relations);
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/04/2020
    @FunctionFor: Question find one
    */
    public function screeningAdd($request){
        $data = $request->all();
        $dataForMaster = [];
        $dataForQuestion = [];
        $dataForOptions = [];
        $checkActiveCount = $this->scrningQuestionRepo->getCount([['status',1]]);
        if($checkActiveCount >= 3){
            $dataForMaster['status'] = 0;
        }
        $dataForMaster['question'] = $data['question_english'];
        $insertMaster = $this->scrningQuestionRepo->create($dataForMaster);
        if($insertMaster){
            $masterId = $insertMaster->id;
            $dataForQuestion = [
                [
                    'master_screening_questions_id' => $masterId,
                    'language' => 'English',
                    'question' => $data['question_english']
                ],
                [
                    'master_screening_questions_id' => $masterId,
                    'language' => 'French',
                    'question' => $data['question_french']
                ],
                [
                    'master_screening_questions_id' => $masterId,
                    'language' => 'Portuguese',
                    'question' => $data['question_portuguese']
                ],
            ];
            $insertQuestion = $this->multiLanguageRepo->multipleRowInsert($dataForQuestion); 
            // NOTE: I am using insart function insted of create for multiple row insert. so created_at and updated_at do not insert default value. at db i have set current_timestamp by default.
            
            $dataForOptions = [
                [
                    'master_screening_questions_id' => $masterId,
                    'language' => 'English',
                    'answer' => $data['answer'],
                    'option_one' => $data['option_one_english'],
                    'option_two' => $data['option_two_english'],
                    'option_three' => $data['option_three_english'],
                    'reason_one' => $data['reson_one_english'],
                    'reason_two' => $data['reson_two_english'],
                    'reason_three' => $data['reson_three_english']
                ],
                [
                    'master_screening_questions_id' => $masterId,
                    'language' => 'French',
                    'answer' => $data['answer'],
                    'option_one' => $data['option_one_french'],
                    'option_two' => $data['option_two_french'],
                    'option_three' => $data['option_three_french'],
                    'reason_one' => $data['reson_one_french'],
                    'reason_two' => $data['reson_two_french'],
                    'reason_three' => $data['reson_three_french']
                ],
                [
                    'master_screening_questions_id' => $masterId,
                    'language' => 'Portuguese',
                    'answer' => $data['answer'],
                    'option_one' => $data['option_one_portuguese'],
                    'option_two' => $data['option_two_portuguese'],
                    'option_three' => $data['option_three_portuguese'],
                    'reason_one' => $data['reson_one_portuguese'],
                    'reason_two' => $data['reson_two_portuguese'],
                    'reason_three' => $data['reson_three_portuguese']
                ],
            ];
            $insertOptions = $this->answerOptionRepo->multipleRowInsert($dataForOptions); 
            // NOTE: I am using insart function insted of create for multiple row insert. so created_at and updated_at do not insert default value. at db i have set current_timestamp by default.
        }
        return $insertMaster ;
    }
     /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 10/04/2020
    @FunctionFor: Question answer update
    */
    public function updateDetails($request){
        $data = $request->all();
        $masterId = $data['master_id'];
        $dataForMaster = [];
        $dataForQuestion = [];
        $dataForOptions = [];
        $dataForMaster['question'] = $data['question_english'];
        $updateMaster = $this->scrningQuestionRepo->update($dataForMaster,$masterId);
        if($updateMaster){

            $dataForQuestion1 = ['question' => $data['question_english']];
            $updateQuestion1 = $this->multiLanguageRepo->update($dataForQuestion1,$data['multi_eng_id']);
            $dataForQuestion2 = ['question' => $data['question_french']];
            $updateQuestion2 = $this->multiLanguageRepo->update($dataForQuestion2,$data['multi_frnch_id']);
            $dataForQuestion3 = ['question' => $data['question_portuguese']];
            $updateQuestion3 = $this->multiLanguageRepo->update($dataForQuestion3,$data['multi_por_id']);
            
            $dataForOptions1 = [
                'answer' => $data['answer'],
                'option_one' => $data['option_one_english'],
                'option_two' => $data['option_two_english'],
                'option_three' => $data['option_three_english'],
                'reason_one' => $data['reson_one_english'],
                'reason_two' => $data['reson_two_english'],
                'reason_three' => $data['reson_three_english']
            ];
            $updateOpt1 = $this->answerOptionRepo->update($dataForOptions1,$data['opt_eng_id']);
            $dataForOptions2 =  [
                'answer' => $data['answer'],
                'option_one' => $data['option_one_french'],
                'option_two' => $data['option_two_french'],
                'option_three' => $data['option_three_french'],
                'reason_one' => $data['reson_one_french'],
                'reason_two' => $data['reson_two_french'],
                'reason_three' => $data['reson_three_french']
            ];
            $updateOpt2 = $this->answerOptionRepo->update($dataForOptions2,$data['opt_frnch_id']);
            $dataForOptions3 =  [
                'answer' => $data['answer'],
                'option_one' => $data['option_one_portuguese'],
                'option_two' => $data['option_two_portuguese'],
                'option_three' => $data['option_three_portuguese'],
                'reason_one' => $data['reson_one_portuguese'],
                'reason_two' => $data['reson_two_portuguese'],
                'reason_three' => $data['reson_three_portuguese']
            ];
            $updateOpt3 = $this->answerOptionRepo->update($dataForOptions3,$data['opt_por_id']);

        }
        return $updateMaster ;
    }

    /** 
     * Fetch Ambassador Details of a specific ID
     * @param $request 
     * @return array $profile
    */
    public function changeStatus($request)
    {
        $updateData = [];
        if($request['status'] == 0){
            $checkActiveCount = $this->scrningQuestionRepo->getCount([['status',1]]);
            if($checkActiveCount >= 3){
                return 'error';
            }
            $updateData['status'] = 1;
        }else{
            $updateData['status'] = 0;
        }
        $id = $request['id'];

        $update = $this->scrningQuestionRepo->update($updateData,$id);
        return $update;       
    }

    public function removeQuestion($id){
        $status = $this->scrningQuestionRepo->delete($id);
        $status = $this->answerOptionRepo->deleteByCondition([['master_screening_questions_id',$id]]);  
        $status = $this->multiLanguageRepo->deleteByCondition([['master_screening_questions_id',$id]]);
        return $status;   
    }

    /**
     * Developer : Rumpa Ghosh 
     * Function to proceed screening mcq
     * @return object Arr data
     */
    public function getActiveData(){
        $condition = [ ["status",1] ];
        $relations = ['multiLangualQuestion','answerOptions'];
        $screeningData = $this->scrningQuestionRepo->getWith($condition,3,$relations)->toArray();
        $mcqData = [];
        if((isset($screeningData['data'])) && (!empty($screeningData['data']))){
            
            if(isset($screeningData['data'][0]) && (!empty($screeningData['data'][0]))){
                //1st Question's English
                $mcqData[0][0]['question'] = $screeningData['data'][0]['multi_langual_question'][0];
                $mcqData[0][0]['answer_options'] = $screeningData['data'][0]['answer_options'][0];
                //1st Question's French
                $mcqData[1][0]['question'] = $screeningData['data'][0]['multi_langual_question'][1];
                $mcqData[1][0]['answer_options'] = $screeningData['data'][0]['answer_options'][1];
                //1st Question's Portugues
                $mcqData[2][0]['question'] = $screeningData['data'][0]['multi_langual_question'][2];
                $mcqData[2][0]['answer_options'] = $screeningData['data'][0]['answer_options'][2];
            }
            if(isset($screeningData['data'][1]) && (!empty($screeningData['data'][1]))){
                //2nd Question's English
                $mcqData[0][1]['question'] = $screeningData['data'][1]['multi_langual_question'][0];
                $mcqData[0][1]['answer_options'] = $screeningData['data'][1]['answer_options'][0];
                //2nd Question's French
                $mcqData[1][1]['question'] = $screeningData['data'][1]['multi_langual_question'][1];
                $mcqData[1][1]['answer_options'] = $screeningData['data'][1]['answer_options'][1];
                //2nd Question's Portugues
                $mcqData[2][1]['question'] = $screeningData['data'][1]['multi_langual_question'][2];
                $mcqData[2][1]['answer_options'] = $screeningData['data'][1]['answer_options'][2];
            }
            if(isset($screeningData['data'][2]) && (!empty($screeningData['data'][2]))){
                //3rd Question's English
                $mcqData[0][2]['question'] = $screeningData['data'][2]['multi_langual_question'][0];
                $mcqData[0][2]['answer_options'] = $screeningData['data'][2]['answer_options'][0];
                //3rd Question's French
                $mcqData[1][2]['question'] = $screeningData['data'][2]['multi_langual_question'][1];
                $mcqData[1][2]['answer_options'] = $screeningData['data'][2]['answer_options'][1];
                //3rd Question's Portugues
                $mcqData[2][2]['question'] = $screeningData['data'][2]['multi_langual_question'][2];
                $mcqData[2][2]['answer_options'] = $screeningData['data'][2]['answer_options'][2];
            }
          
        }
        return $mcqData;
    }
    /**
     * Developer : Rumpa Ghosh 
     * Function to proceed screening mcq
     * @return object Arr data
     */
    public function updateUser(){
        $id = Auth::user()->id;
        $updateData['is_mcq_complete'] = 1;
        $update = $this->userRepo->update($updateData,$id);
        return $update;
    }
    /**
     * Developer : Rumpa Ghosh 
     * Function to inser screening user answer
     * @return object Arr data
     */
     public function screeningUserAnswer($request){
        $userId = Auth::user()->id;
        $inserdata[] = [];
        for($i=0; $i<$request['total']; $i++){
            $inserdata[$i]['user_id'] = $userId;
            $inserdata[$i]['master_screening_questions_id'] = $request['master_screening_questions_id_'.$i];
            $inserdata[$i]['answer_option'] = $request['check_'.$i];
        }
       $insertData = $this->screeningUserAnswer->multipleRowInsert($inserdata);
       return $insertData;
    }
}