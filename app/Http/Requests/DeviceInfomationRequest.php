<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class DeviceInfomationRequest extends FormRequest

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
    public function rules() {
        return [
            'deviceType' =>'required',
            'deviceOs'    =>'required', 
            'deviceModel'  =>'required',
            'deviceVersion'  =>'required',
            'deviceManufactory'=>'required'
        ];
    }

    public function messages() {
        return [
            'deviceType.required'        =>'Please choose Type',
            'deviceOs.required'          =>'Please choose Os',
            'deviceModel.required'       =>'Please choose Model',
            'deviceVersion.required'     =>'Please choose Version',
            'deviceManufactory.required' =>'Please choose Manufactory',
        ];
    }
}
