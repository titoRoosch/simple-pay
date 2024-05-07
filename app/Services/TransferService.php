<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TransferService {

    private function authorize() {

        $response = Http::get('https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception("Requisition failed: " . $response->status());
        }

    }

    public function transfer($data) {

        $authorization = $this->authorize();

        if($authorization['message'] !== 'Autorizado') {
            throw new \InvalidArgumentException("Unauthorized transaction");
        }

        $wallet1 = Wallet::where('user_id', $data['payer'])->first();
        $wallet2 = Wallet::where('user_id', $data['payee'])->first();

        try {
            $transfer = $wallet1->transfer($wallet2, $data['value']);
            $this->sendMessage();

            return $transfer;
        }  catch (\Exception $e) {
            throw new \InvalidArgumentException( $e->getMessage());
        }
    }

    private function sendMessage() {
        $response = Http::get('https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6');

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception("Requisition failed: " . $response->status());
        }
    }

    public function cancel($id) {

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