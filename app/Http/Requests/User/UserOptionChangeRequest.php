<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserOptionChangeRequest extends FormRequest
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
            'language' => ['string', 'sometimes', 'max:5', 'config_has_key:thesaurus.languages'],
            'timezone' => ['string', 'sometimes', 'max:50', 'config_has_key:thesaurus.timezones'],
        ];
    }
}
