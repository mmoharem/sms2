<?php
namespace App\Http\Requests\Secure;

use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Foundation\Http\FormRequest;


class AttendanceSectionGetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date_format:"' . Settings::get('date_format') . '"',
            'section_id' => 'required',
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