<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\BaseRequest;

class StorePermissionRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,NULL,id,guard_name,admin'],
            'group' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a permission name.',
            'name.unique' => 'This permission name already exists.',
            'group.required' => 'Please select a permission group.',
        ];
    }
}
