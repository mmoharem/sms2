<?php namespace App\Http\Requests\Secure;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        "user_id" => 'required',
                        "title" => 'required',
                        "amount" => 'required|regex:/^\d{1,10}(\.\d{1,2})?$/',
                        "description" => 'required|min:3',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        "amount" => 'required|regex:/^\d{1,10}(\.\d{1,2})?$/',
                        "title" => 'required',
                        "description" => 'required|min:3',
                    ];
                }
            default:
                break;
        }

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
