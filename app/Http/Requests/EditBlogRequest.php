<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditBlogRequest extends FormRequest
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
            'category_id'=>'required',
            'title'=>'required|string|min:3|max:100',
            'short_description'=>'required|string|min:10|max:200',
            'summary'=>'required',
            'featured_img1'=>'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'featured_img2'=>'sometimes|required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author_name'=>'required|string|min:2|max:50',
            'added_date'=>'required|date',

        ];
    }
}
