<?php

namespace App\Http\Requests\backends\setups;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;

class StoreLookupDetailRequest extends FormRequest
{
    private const VALIDATION_RULES = [
        'name' => 'required|unique:lookup_details',
        'lookup_details' => 'nullable|unique:lookups',
    ];
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
        $rules = [];
        if ($this->getMethod() == 'POST') {
            $id = Crypt::decrypt($this->lookup);
            $rules = [
                'name' => ['required',
                    Rule::unique('lookup_details')->where(function ($query) use ($id){
                        return $query->where('active_fg', 1)->where('lookup_id', $id);
                    }),
                ],
                'udid' => ['nullable',
                    Rule::unique('lookup_details')->where(function ($query) use ($id){
                        return $query->where('active_fg', 1)->whereNotNull('udid')->where('lookup_id', $id);
                    }),
                ],
            ];
        }else if ($this->getMethod() == 'PATCH'){
            $rules = [
                'name' => ['required',
                    Rule::unique('lookup_details')->where(function ($query){
                        return $query->where('active_fg', 1)->where('lookup_id', $this->lookup_detail->lookup_id)->where('id','<>', $this->lookup_detail->id);
                    }),
                ],
                'udid' => ['nullable',
                    Rule::unique('lookup_details')->where(function ($query){
                        return $query->where('active_fg', 1)->whereNotNull('udid')->where('lookup_id', $this->lookup_detail->lookup_id)->where('id','<>', $this->lookup_detail->id);
                    }),
                ],
            ];
        }
        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Name',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
