<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'topic_id'=>'required',
            'name'=>'required|string|min:3|max:100',
            'slug'=>'required|string|min:3|max:100',
            'logo'=>'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
