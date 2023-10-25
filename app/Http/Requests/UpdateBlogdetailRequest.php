<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogdetailRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'blog_id'=>'required',
            'keywords'=>'required',
            'title'=>'required|string|min:3|max:100',
            'description'=>'required|string|min:5|max:200',
            'summary'=>'required',
        ];
    }
}
