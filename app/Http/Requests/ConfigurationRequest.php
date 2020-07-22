<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
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
        $action = $this->route()->getActionMethod();

        return $this->$action();
    }

    public function store()
    {
        return [
            '*.name' => "required|max:50|RequestFieldValueUnique|uniqueIfGivenAttrDoesntExists:uuid",
            '*.hostname' => "required|ipv4|RequestFieldValueUnique|uniqueIfGivenAttrDoesntExists:uuid",
            '*.port' => "required|integer",
            '*.rotation_speed' => "required|integer",
            '*.left_engine_speed' => "required|integer",
            '*.right_engine_speed' => "required|integer"
        ];
    }
}
