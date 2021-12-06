<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $user = User::find($this->route('user'));

        // return $user && $this->user()->can('update', $user);

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
            'name'        => 'required|unique:companies',
            'category_id' => 'required|exists:company_categories,id',
            // 'logo' => 'required|file',
        ];
    }

    public function validated()
    {
        $validated = $this->validator->validated();

        return $this->sanitize($validated);
    }

    protected function sanitize($validated)
    {
        return $validated;
    }

    // public function messages() { }
}
