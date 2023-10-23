<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTopicdetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'topic_id' => 'required',
            'country_id' => 'required',
            'heading' => 'required',
            'summary' => 'required',
            'detail' => 'required',
            'overview' => 'required',
            'whats_included' => 'required',
            'pre_requisite' => 'required',
            'who_should_attend' => 'required',
            'meta_title' => 'required',
            'meta_keywords' => 'required',
            'meta_description' => 'required',
        ];
    }
}
