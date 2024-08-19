<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'image' => 'required',
            'price' => 'required',
            'description' => 'string|required',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')){
            $response = ApiResponse::sendResponse(422, 'Validation Error', $validator->errors());
            throw new ValidationException($validator, $response);
        }
    }
    public function attributes()
    {
        return [
            'name' => 'Course Name',
            'image' => 'Course Image',
            'price' => 'Course Price',
            'description' => 'Course Description',
            'category_id' => 'Category',

        ];
    }
}
