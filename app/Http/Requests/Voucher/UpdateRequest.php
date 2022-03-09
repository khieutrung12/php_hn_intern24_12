<?php

namespace App\Http\Requests\Voucher;

use App\Models\Voucher;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|min:6|max:255',
            'quantity' => 'required|numeric|min:1',
            'value' => 'required|numeric|min:1',
            'condition_min_price' => 'required|numeric|min:0',
            'maximum_reduction' => 'required|numeric|min:1',
            'start_date' => 'required',
            'end_date' => 'required|max:' . request()->start_date,
        ];
    }
}
