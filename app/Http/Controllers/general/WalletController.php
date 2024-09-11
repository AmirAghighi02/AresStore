<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\ChargeWithdrawRequest;
use App\Http\Resources\Wallet\WalletResource;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use Modules\ResponseHandler\Services\ResponseConverter;
use Modules\ResponseHandler\Utils\ResponseUtil;

class WalletController extends Controller
{
    public function charge(ChargeWithdrawRequest $request)
    {
        $transaction = (new WalletService(Auth::user()))->charge($request->validated()['amount']);

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setData([
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'type' => $transaction->type->label(),
                ])
                ->setMessage('wallet.charge.created')
        );
    }

    public function withdraw(ChargeWithdrawRequest $request)
    {
        $transaction = (new WalletService(Auth::user()))->charge($request->validated()['amount']);

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setData([
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'type' => $transaction->type->label(),
                ])
        );
    }

    public function balance()
    {
        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setData([
                    'balance' => Auth::user()->wallet->balance ?? 0,
                ])
                ->setMessage('wallet.balance.get')
        );
    }

    public function index()
    {
        $wallets = Wallet::with('user')->paginate(config('general.default_pagination_limit'));

        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setData(WalletResource::collection($wallets))
                ->setMessage('wallet.index')
        );
    }

    public function show(Wallet $wallet)
    {
        return ResponseConverter::convert(
            ResponseUtil::builder()
                ->setAction(__FUNCTION__)
                ->setData(new WalletResource($wallet->load('user')))
                ->setMessage('wallet.show')
        );
    }
}
