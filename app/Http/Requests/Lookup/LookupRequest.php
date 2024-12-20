<?php

declare(strict_types=1);

namespace App\Http\Requests\Lookup;

use App\Enums\TypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class LookupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|in:' . implode(',', TypeEnum::values()),
            'id' => 'required_without:username|string',
            'username' => 'required_without:id|string',
        ];
    }
}
