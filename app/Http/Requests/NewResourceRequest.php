<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewResourceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [ 'required', 'max:255' ],
            'resource_type' => ['required', 'in:file,html,link'],
            'file' => [ 'required_if:resource_type,file', 'file' ],
            'snippet_description' => [ 'required_if:resource_type,html' ],
            'snippet_html' => [ 'required_if:resource_type,html' ],
            'link' => ['required_if:resource_type,link', 'url'],
            'link_in_new_tab' => ['boolean'],
        ];
    }

    /**
     * Make sure the checkbox is always a boolean
     */
    protected function getValidatorInstance(): \Illuminate\Contracts\Validation\Validator
    {
        $this->request->set(
            'link_in_new_tab',
            filter_var($this->request->get('link_in_new_tab'), FILTER_VALIDATE_BOOLEAN)
        );

        return parent::getValidatorInstance();
    }

}
