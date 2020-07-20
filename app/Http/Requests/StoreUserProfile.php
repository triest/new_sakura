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
                    'sex' => 'required|'
            ];
        }

        public function messages()
        {
            return [
                    'date_birth.before' => 'Вам должно быть больше 18 лет',
                    'name.required'=>'Имя должно быть не менее 2 символов.',
                    'description.min'=>'Укажите дольше информации о себе. Минимум 30 символов.'
            ];
        }
    }
