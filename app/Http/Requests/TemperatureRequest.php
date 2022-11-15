<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TemperatureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request): bool
    {
        $xToken = config("ow.token");
        return $request->header('x-token') === $xToken;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'date' => 'required|date_format:"Y-m-d"',
        ];

        switch ($this->getMethod()) {
            case 'GET':
            default:
                return $rules;

        }
    }

    public function messages(): array
    {
        return [
            'date.required' => 'A date is required',
            'date.date_format' => 'A date must be in format: Y-m-d',
            'date.exists' => 'This date doesn\'t exists',
        ];
    }
}
