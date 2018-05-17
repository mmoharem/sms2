<?php namespace App\Http\Requests\Secure;

use App\Models\User;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Foundation\Http\FormRequest;

class SchoolDirectionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'school_id' => 'required',
            'direction_id' => 'required'
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
