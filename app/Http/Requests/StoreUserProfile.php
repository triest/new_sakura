<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserProfile extends FormRequest
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
                'name' => 'required|string|min:2',
                'date_birth' => 'required|date|before:-18 years',
                'description' => 'min:30',
                'sex' => 'required|',
                'relation_id'=>'required|exists:relation,id',
              //   'file-upload-photo-profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function messages()
    {
        return [
                'date_birth.before' => 'Вам должно быть больше 18 лет',
                'date_birth.required' => 'Дата рождения обязательна',
                'name.required' => 'Имя должно быть не менее 2 символов.',
                'name.min' => 'Имя должно быть не менее 2 символов.',
                'description.min' => 'Укажите больше информации о себе. Минимум 30 символов.',
        ];
    }
}
