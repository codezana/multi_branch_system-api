<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTransactionRequest extends FormRequest {
    /**
    * Determine if the user is authorized to make this request.
    */

    public function authorize(): bool {
      //  return Auth::id() === 'admin';
      return true;
    }

    // protected function failedAuthorization() {
    //     throw new AuthorizationException( 'You are not authorized to make this request , you are not admin.' );
    // }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */

    public function rules(): array {
        return [
            'branch_id' => 'required|integer|exists:branches,id',
            'category_id' => 'required|integer|exists:categories,id',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|decimal:0,2|min:0.01',
            'description' => 'nullable|string',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}
