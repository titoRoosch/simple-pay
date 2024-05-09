<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repositories\WalletRepositoryInterface;

class WalletService {

    protected $walletRepository;

    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function getUserWallet($userId)
    {
        return $this->walletRepository->getByUserId($userId);
    }

    public function withdrawalFromWallet(array $data, $userId)
    {
        return $this->walletRepository->withdrawal($data, $userId);
    }

    public function depositOnWallet(array $data, $userId)
    {
        return $this->walletRepository->deposit($data, $userId);
    }
}