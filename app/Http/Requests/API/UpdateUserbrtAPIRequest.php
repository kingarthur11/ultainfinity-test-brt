<?php

namespace App\Http\Requests\API;

use App\Models\Userbrt;
use InfyOm\Generator\Request\APIRequest;

class UpdateUserbrtAPIRequest extends APIRequest
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
            'reserved_amount' => 'required|numeric|between:0,99999999.99',
            'status' => 'required|string|in:active,inactive'
        ];
        // return Userbrt::$rules;
        // $rules = Userbrt::$rules;
        
        // return $rules;
    }

    // public function messages()
    // {
    //     return [
    //         'firstName.required' => 'A firstName is required',
    //         'lastName.required'  => 'lastName is required',
    //         'email.required'  => 'A email is required',
    //     ];
    // }
}
