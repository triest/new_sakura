<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
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
            //
                'name' => 'required',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'end_date' => 'date',
                'end_time' => 'date_format:H:i',
                'description' => 'required',
                'min' => 'integer|min:0',
                'max' => 'integer|min:0'
        ];
    }

    public function messages()
    {
        return [
                'min.min' => 'неверное число',
                'max.min' => 'неверное число',
                'min.integer' => 'болжно быть больще 1',
                'max.integer' => 'болжно быть больще 1'
        ];
    }
}
