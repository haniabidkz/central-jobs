<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $datanew = [];
        $datanew = $request->all();
        if(!empty($datanew)){
            if($datanew['category_id'] == 1){
                return [
                    'category_id' => 'required',
                    'title_job' => 'required',
                    'description_job' => 'required',
                    'country_id' => 'required',
                    'state_id' => 'required',
                    'city' => 'required',
                    'position_for' => 'required',
                    'employment_type' => 'required',
                    'language' => 'required',
                    'skill' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'applied_by' => 'required',
                    'user_id' => 'required'
                ];
            }
            else if($datanew['category_id'] == 2){
                return [
                    'title_text' => 'required',
                    'description_text' => 'required'
                ];
            }
            else if($datanew['category_id'] == 3){
                return [
                    'image'      =>   'mimes:jpeg,png,jpg,bmp|max:2048',
                    'title_img' => 'required',
                    'description_img' => 'required'
                ];
            }
            else if($datanew['category_id'] == 4){
                return [
                    'video'      =>   'required',
                    'title_vdo' => 'required',
                    'description_vdo' => 'required'
                ];
            }
            
        }
        
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    // public function messages(Request $request)
    // {
    //     $datanew = [];
    //     $datanew = $request->all();
    //     if(!empty($datanew)){
    //         if($datanew['category_id'] == 1){
    //         return [
    //             'category_id.required' => 'Please select post type.',
    //             'title_job.required' => 'Please enter job title.',
    //             'description_job.required' => 'Please enter job description.',
    //             'cntrId.required' => 'Please select country.',
    //             'state_id.required' => 'Please select state.',
    //             'city.required' => 'Please enter city.',
    //             'position_for.required' => 'Please select position.',
    //             'employment_type.required' => 'Please selete job type.',
    //             'language.required' => 'Please enter language.',
    //             'skill.required' => 'Please select skill.',
    //             'start_date.required' => 'Please select start date.',
    //             'end_date.required' => 'Please select end date.',
    //             'applied_by.required' => 'Please select apply process.',
    //             'user_id.required' => 'Please select company name.'
    //             ];
    //         }
    //     }
    // }
}
