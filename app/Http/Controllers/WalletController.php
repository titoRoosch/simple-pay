<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\WalletService;
use App\Models\User;

class WalletController extends Controller
{
    protected $walletService;

    /**
     * Create a new WalletController instance.
     *
     * @return void
     */
    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function show($userId) {
        $wallet = $this->walletService->getUserWallet($userId);
        return response()->json($wallet);
    }

    public function withdrawal(WalletRequest $request, $userId) {

        $data = [
            'value' => $request['value'],
        ];
        
        $wallet = $this->walletService->withdrawalFromWallet($data, $userId);
        return response()->json($wallet);
    }

    public function deposit(WalletRequest $request, $userId) {

        $data = [
            'value' => $request['value'],
        ];
        
        $wallet = $this->walletService->depositOnWallet($data, $userId);
        return response()->json($wallet);
    }

}