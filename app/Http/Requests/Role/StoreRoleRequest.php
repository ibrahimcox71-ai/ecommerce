<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseRequest;

class StoreRoleRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,NULL,id,guard_name,admin'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter a role name.',
            'name.unique' => 'This role name already exists.',
            'permissions.*.exists' => 'Selected permission is invalid.',
        ];
    }
}
