<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class JobEditRequest extends FormRequest
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
    public function rules()
    {
        
        return [
            'title' => 'required',
            'description' => 'required',
            'country_id' => 'required',
            'city' => 'required',
            'seniority' => 'required',
            'employment' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'applied_by' => 'required',
            'user_id' => 'required'
        ];
    
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Please enter job title.',
            'description.required' => 'Please enter job description.',
            'country_id.required' => 'Please select country.',
            'city.required' => 'Please enter city.',
            'seniority.required' => 'Please select position.',
            'employment.required' => 'Please selete job type.',
            'start_date.required' => 'Please select start date.',
            'end_date.required' => 'Please select end date.',
            'applied_by.required' => 'Please select apply process.',
            'user_id.required' => 'Please select company name.'
        ];
    }
}
