<?php namespace App\Http\Requests\Secure;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|min:3',
            'debit_account_id'  => 'required',
            'credit_account_id'  => 'required',
            'amount'  => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

}
