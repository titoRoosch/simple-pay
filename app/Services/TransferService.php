<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transfer;
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

        $transfer = $wallet1->transfer($wallet2, 100);
        $this->sendMessage();
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



    }
}