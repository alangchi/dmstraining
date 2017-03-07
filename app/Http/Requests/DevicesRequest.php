<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class DevicesRequest extends FormRequest
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
            'name'    =>'required',
            'device_code'=>'required|unique:devices,device_code',
            'description' =>'required',
            'image'        =>'required|image',
            'type_id'      =>'required',
            'os_id'        =>'required',
            'version_id'   =>'required',
            'manufatory_id'=>'required',
            'model_id'     =>'required',
        ];
    }

    public function messages() {
        return [
            'name.required'    =>'Enter device name',
            'device_code.required'=>'Enter device code',
            'device_code.unique'  =>'Device Code is unique. Please choose different!',
            'image.required'        =>'Please choose image',
            'description.required'  =>'Enter device description',
            'image.image'           =>'This file isn\'t image. Please choose corect image type!',
            'type_id.required'      =>'Please select Type',
            'os_id.required'        =>'Please select Os',
            'version_id.required'   =>'Please select Veision',
            'manufatory_id.required'=>'Please select Manufactory',
            'model_id.required'     =>'Please select Model',
        ];
    }
}
