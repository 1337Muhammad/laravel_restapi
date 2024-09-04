<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;  //ToDo: change return to false , to make only authorized users to send that request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // validatiing array of objects [{}, {}, ...]   ---> we have t validate each individual object
        return [
            '*.customerId' => ['required', 'integer'],
            '*.amount' => ['required', 'numeric'],
            '*.status' => ['required', Rule::in(['B', 'P', 'V', 'b', 'p', 'v'])],
            '*.billedDate' => ['required', 'date_format:Y-m-d H:i:s'],
            '*.paidDate' => ['nullable', 'date_format:Y-m-d H:i:s'],
        ];
    }

    /** Converting camelCase property to its underscore_property */
    protected function prepareForValidation()
    {
        // iterate for each element in the arr
        $data = [];

        foreach ($this->toArray() as $obj) {
            // checking if user didn't enter any of these variables at first and if yes we will nullify it to fail in validation
            $obj['customer_id'] = $obj['customerId'] ?? NULL;
            $obj['billed_date'] = $obj['billedDate'] ?? NULL;
            $obj['paid_date'] = $obj['paidDate'] ?? NULL;

            $data[] = $obj;
        }
        // dd($data);

        $this->merge($data);
    }
}
