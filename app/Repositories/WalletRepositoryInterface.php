<?php

namespace App\Repositories;

interface WalletRepositoryInterface
{
    public function getByUserId($id);

    public function withdrawal(array $data, $id);

    public function deposit(array $data, $id);
}