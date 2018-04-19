<?php

namespace App\Http\Requests\Quiz;

use App\Http\Requests\Request;

class createSoalRequest extends Request
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
            'soal'  => 'required',
            'gambar_soal' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // max 2MB
        ];
    }
}
