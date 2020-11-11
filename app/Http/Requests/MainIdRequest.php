<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainIdRequest extends FormRequest
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
            'm_id' => 'required|min:10|max:50'
        ];
    }

    /**
     * To get param on HTTP GET Method
     *
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all();
        $data['m_id'] = $this->route('m_id');

        return $data;
    }

    /**
     * Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'm_id' => 'trim',
        ];
    }
}
