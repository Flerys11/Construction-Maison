<?php

namespace App\Http\Requests;

use App\Models\SousTravaux;
use Illuminate\Foundation\Http\FormRequest;

class CreateSousTravauxRequest extends FormRequest
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
        return SousTravaux::$rules;
    }
}
