<?php

namespace App\Http\Requests\Wallet;

use App\Enums\WalletStatus;
use App\Exceptions\Wallet\UserWalletException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChargeWithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->wallet?->status === WalletStatus::ACTIVE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1000'],
        ];
    }

    protected function failedAuthorization()
    {
        throw new UserWalletException('user.wallet.errors.disabled');
    }
}
