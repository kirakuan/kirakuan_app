<?php

namespace App\Http\Controllers\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class ReservationCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => ['required', 'string'],
            'user_id' => ['required', 'string'],

            'start_date' => 'required',
            'start_time' => 'required',

            'end_date' => 'required',
            'end_time' => 'required',
            'staff_id' => 'string',
            'service_master_id' => ['required', 'string'],
        ];
    }

    /**
     * バリデータを取得する
     * @return  \Illuminate\Contracts\Validation\Validator  $validator
     */
    public function getValidator()
    {
        return $this->validator;
    }
}
