<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Wallet;

class EloquentWalletRepository implements WalletRepositoryInterface {

    public function getByUserId($userId)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        if(!$wallet) {
            return false;
        }

        return $wallet;
    }

    public function withdrawal(array $data, $userId)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        if(!$wallet) {
            return false;
        }

        $wallet->decrement('balance', $data['value']);
        return $wallet;
    }

    public function deposit(array $data, $userId)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        if(!$wallet) {
            return false;
        }

        $wallet->increment('balance', $data['value']);
        return $wallet;
    }

}