<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\Wallet;

class EloquentTransferRepository implements TransferRepositoryInterface {

    public function transfer($data){
        $wallet1 = Wallet::where('user_id', $data['payer'])->first();
        $wallet2 = Wallet::where('user_id', $data['payee'])->first();   

        try {
            $transfer = $wallet1->transfer($wallet2, $data['value']);
            return $transfer;
        }  catch (\Exception $e) {
            throw new \InvalidArgumentException( $e->getMessage());
        }
    }

    public function cancel($id){

        try {
            $transaction = Transaction::findOrFail($id);
    
            $payerWallet = Wallet::findOrFail($transaction->payer_wallet);
            $payeeWallet = Wallet::findOrFail($transaction->payee_wallet);
    
            $payerWallet->increment('balance', $transaction->amount);
            $payeeWallet->decrement('balance', $transaction->amount);
    
            $transaction->delete();
    
            return "Transaction reverted.";
        } catch (ModelNotFoundException $e) {
            return "Transaction not found.";
        } catch (\Exception $e) {
            return "Transaction Cancel Error: " . $e->getMessage();
        }

    }
}