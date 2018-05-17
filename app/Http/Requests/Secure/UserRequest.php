<?php namespace App\Http\Requests\Secure;

use App\Models\User;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                if(Settings::get('generate_registration_code')==true && Settings::get('self_registration_role')=='student'){
                    return [
                        'registration_code' => 'required|min:3|max:50',
                        'first_name' => 'required|min:3|max:50|alpha',
                        'last_name' => 'required|min:3|max:50|alpha',
                        'email' => 'required|email|unique:users,email',
                        'password' => 'required|min:6|confirmed',
                    ];
                }else {
                    return [
                        'first_name' => 'required|min:3|max:50|alpha',
                        'last_name' => 'required|min:3|max:50|alpha',
                        'email' => 'required|email|unique:users,email',
                        'password' => 'required|min:6|confirmed',
                    ];
                }
            }
            case 'PUT':
            case 'PATCH': {
                if (preg_match("/\/(\d+)$/", $this->url(), $mt))
                    $user = User::find($mt[1]);

                return [
                    'first_name' => 'required|min:3|max:50|alpha',
                    'last_name' => 'required|min:3|max:50|alpha',
                    'email' => 'required|email|unique:users,email,' . $user->id,
                    'password' => 'min:6|confirmed',
                ];
            }
            default:
                break;
        }

        return [

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
