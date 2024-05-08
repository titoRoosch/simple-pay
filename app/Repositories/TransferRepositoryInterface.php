<?php

namespace App\Repositories;

interface TransferRepositoryInterface
{
    public function transfer(array $data);

    public function cancel($id);
}