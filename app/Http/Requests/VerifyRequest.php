<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User;

class VerifyRequest extends Request
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
	        'envato' => 'required',
	        'envato_username' => 'required_if:envato,yes',
	        'envato_email' => 'required_if:envato,yes',
	        'purchase_code' => 'required_if:envato,yes',
	        'secret' => 'required_if:envato,no',
	        'license' => 'required_if:envato,no',
	        'email' => 'required_if:envato,no',
        ];
    }
}
