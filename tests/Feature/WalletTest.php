<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestBase;

class WalletTest extends TestBase
{
    use DatabaseTransactions;

    public function testGetWallet(): void
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken('super');

        $response = $this->makeRequest('get', '/api/wallet/show/'.$mock['user']->id, $authData['header']);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals($responseData['id'], $mock['wallet']->id);
    }

    public function testGetUserWallet(): void
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken();

        $response = $this->makeRequest('get', '/api/wallet/show/'.$authData['user']->id, $authData['header']);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals($responseData['id'], $authData['wallet']->id);
    }

    public function testWithdrawalWallet(): void
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken();

        $data = [
            "value" => 100.0,
        ];

        $response = $this->makeRequest('post', '/api/wallet/withdrawal/'.$authData['user']->id, $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals($responseData['id'], $authData['wallet']->id);
        $this->assertEquals(0, $responseData['balance']);
    }

    public function testDepositWallet(): void
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken();

        $data = [
            "value" => 100.0,
        ];

        $response = $this->makeRequest('post', '/api/wallet/deposit/'.$authData['user']->id, $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(200);
        $this->assertEquals($responseData['id'], $authData['wallet']->id);
        $this->assertEquals(200, $responseData['balance']);
    }

    protected function mocks()
    {
        $user = User::factory()->create();
        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'balance' => 100
        ]);

        return [
            'user' => $user,
            'wallet' => $wallet
        ];

    }
}