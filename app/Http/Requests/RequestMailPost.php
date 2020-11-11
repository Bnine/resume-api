<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestMailPost extends FormRequest
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
            'sender_name' => 'required|min:2|max:100',
            'sender_email' => 'email|required|min:2|max:255',
            'subject' => 'required|min:5|max:255',
            'contents' => 'required|min:5',
        ];
    }

    /**
     * Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'sender_name' => 'trim',
            'sender_email' => 'trim',
            'subject' => 'trim',
            'contents' => 'trim',
        ];
    }
}
