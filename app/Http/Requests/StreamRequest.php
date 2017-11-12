<?php

namespace App\Http\Requests;

use App\Rules\ArrayNumeric;
use Illuminate\Foundation\Http\FormRequest;

class StreamRequest extends FormRequest
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
            'game_id'     => new ArrayNumeric(),
            'game_id.*'   => 'numeric',
            'period_from' => 'date',
            'period_to'   => 'date',
        ];
    }
}