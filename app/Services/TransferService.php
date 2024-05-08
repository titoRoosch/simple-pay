<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repositories\TransferRepositoryInterface;

class TransferService {

    protected $transferRepository;

    public function __construct(TransferRepositoryInterface $transferRepository)
    {
        $this->transferRepository = $transferRepository;
    }

    private function authorize() {

        $response = Http::get('https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception("Requisition failed: " . $response->status());
        }

    }

    public function createTransaction($data) {

        $authorization = $this->authorize();

        if($authorization['message'] !== 'Autorizado') {
            throw new \InvalidArgumentException("Unauthorized transaction");
        }

        try {
            $transfer = $this->transferRepository->transfer($data);
            $this->sendMessage();
            return ['success' => true, 'data' => $transfer];
        } catch (\InvalidArgumentException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
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

    public function cancelTransaction($id) {

        $this->transferRepository->cancel($id);

    }
}