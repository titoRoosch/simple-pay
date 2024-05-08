<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TransferService;
use App\Models\User;

class TransferController extends Controller
{

    protected $transferService;

    /**
     * Create a new TransferController instance.
     *
     * @return void
     */
    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function transfer(TransferRequest $request)
    {
        $data = $request->only('value', 'payer', 'payee');
        $transfer = $this->transferService->createTransaction($data);
        if(!$transfer['success']){
            return response()->json(['error' => $transfer['message']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($transfer);
    }

    public function cancel($id)
    {
        $delete = $this->transferService->cancelTransaction($id);
        return response()->json($delete);
    }
}