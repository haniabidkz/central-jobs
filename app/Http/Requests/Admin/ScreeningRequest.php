<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ScreeningRequest extends FormRequest
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
            "question_english" => "required",
            "option_one_english" => "required",
            "option_two_english" => "required",
            "option_three_english" => "required",
            "reson_one_english" => "required",
            "reson_two_english" => "required",
            "reson_three_english" => "required",
            "question_french" => "required",
            "option_one_french" => "required",
            "option_two_french" => "required",
            "option_three_french" => "required",
            "reson_one_french" => "required",
            "reson_two_french" => "required",
            "reson_three_french" => "required",
            "question_portuguese" => "required",
            "option_one_portuguese" => "required",
            "option_two_portuguese" => "required",
            "option_three_portuguese" => "required",
            "reson_one_portuguese" => "required",
            "reson_two_portuguese" => "required",
            "reson_three_portuguese" => "required",
            "answer" => "required"
                    
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    // public function messages()
    // {
    //     return [
    //         'category_id.required' => 'Please select project category.',
    //         'title.required' => 'Please enter video title.',
    //         'youtube_video_key.required' => 'Please enter youtube video key.',
    //         'description.required' => 'Please enter video description.'
    //     ];
    // }
}
