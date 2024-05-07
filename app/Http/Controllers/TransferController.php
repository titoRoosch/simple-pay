<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TransferService;
use App\Models\User;

class TransferController extends Controller
{

    protected $tranferService;

    /**
     * Create a new TransferController instance.
     *
     * @return void
     */
    public function __construct(TransferService $tranferService)
    {
        $this->tranferService = $tranferService;
    }

    public function transfer()
    {

    }

    public function cancel()
    {

    }
}