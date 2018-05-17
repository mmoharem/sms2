<?php
namespace App\Http\Requests\Secure;

use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Foundation\Http\FormRequest;


class VisitorLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required',
            'visited_user_id' => 'required',
            'check_in' => 'required|date_format:"' . Settings::get('date_format') .' '.Settings::get('time_format') . '"',
            'check_out' => 'date_format:"' . Settings::get('date_format') .' '.Settings::get('time_format') . '"'
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