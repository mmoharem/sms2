<?php

namespace App\Http\Requests\Secure;

use App\Http\Requests\Request;

class SliderRequest extends Request
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'title' => 'required',
                        'content' => 'required',
                        'image_file' => 'required|image',
                        'url' => 'url',
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'title' => 'required',
                        'content' => 'required',
                        'url' => 'url',
                    ];
                }
            default:
                break;
        }
    }

}
