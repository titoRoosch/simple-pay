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
        $this->transferService->transfer($data);
    }

    public function cancel(TransferRequest $request, $id)
    {
        $this->transferService->cancel($data);
    }
}