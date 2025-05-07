<?php

namespace App\Http\Requests;

use App\Models\Lead;
use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            Lead::COLUMN_CATEGORY_ID => $this->input('categoryId'),
            Lead::COLUMN_STAGE_ID => $this->input('stageId'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            Lead::COLUMN_NAME => 'required|string',
            Lead::COLUMN_PHONE => 'required|string|max:15',
            Lead::COLUMN_GENDER => 'required|in:Male,Female',
            Lead::COLUMN_ADDRESS => 'nullable|string|max:255',
            Lead::COLUMN_DATE => 'required|date',
            Lead::COLUMN_CATEGORY_ID => 'required',
            Lead::COLUMN_STAGE_ID => 'required',
            Lead::COLUMN_NOTE => 'nullable|string',
        ];
    }
}
