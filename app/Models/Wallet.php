<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transfer(Wallet $recipient, $amount)
    {
        if ($this->id === $recipient->id) {
            throw new \InvalidArgumentException("Cannot transfer to the same wallet");
        }

        if ($this->balance < $amount) {
            throw new \InvalidArgumentException("Insufficient balance");
        }

        // Carrega os usuários associados aos wallets
        $this->load('user');
        $recipient->load('user');

        return $this->getConnection()->transaction(function () use ($recipient, $amount) {
            $this->decrement('balance', $amount);
            $recipient->increment('balance', $amount);

            return Transaction::create([
                'payer_id' => $this->user_id, // Acessa o ID do usuário associado a este wallet
                'payee_id' => $recipient->user_id, // Acessa o ID do usuário associado ao wallet do destinatário
                'payer_wallet' => $this->id,
                'payee_wallet' => $recipient->id,
                'amount' => $amount,
            ]);
        });
    }


}
