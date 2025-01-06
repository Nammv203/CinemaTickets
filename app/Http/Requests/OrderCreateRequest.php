<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedule_publish_films,id',
            'status' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id' => 'ID khách hàng',
            'status' => 'Trạng thái',
            'schedule_id' => 'Lịch chiếu',
        ];
    }
}