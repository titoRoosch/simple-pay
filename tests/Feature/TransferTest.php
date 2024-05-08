<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestBase;

class TransferTest extends TestBase
{
    use DatabaseTransactions;

    public function testSucessTransfer()
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken();

        $data = [
            "value" => 100.0,
            "payer" => $authData['user']->id,
            "payee" => $mock ['users'][0]->id
        ];

        $response = $this->makeRequest('post', '/api/transfer', $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(200);
    }

    public function testForbiddenTransfer()
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken('shopkeeper');


        $data = [
            "value" => 100.0,
            "payer" => $authData['user']->id,
            "payee" => $mock ['users'][0]->id
        ];

        $response = $this->makeRequest('post', '/api/transfer', $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(403);
    }

    public function testInvalidTransfer()
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken();


        $data = [
            "value" => 100000.0,
            "payer" => $authData['user']->id,
            "payee" => $mock ['users'][0]->id
        ];

        $response = $this->makeRequest('post', '/api/transfer', $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);
        $response->assertStatus(500);
    }

    public function testSucessCancelTransfer()
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken();

        $data = [
            "value" => 100.0,
            "payer" => $authData['user']->id,
            "payee" => $mock ['users'][0]->id
        ];

        $response = $this->makeRequest('post', '/api/transfer', $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $authData = $this->createUserAndGetToken('super');
        $response = $this->makeRequest('delete', '/api/transfer/cancel/'.$responseData['data']['id'], $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(200);
    }

    protected function mocks()
    {
        $user = User::factory(2)->create();
        $wallet = Wallet::factory()->create([
            'user_id' => $user[0]->id,
            'balance' => 100
        ]);

        $wallet = Wallet::factory()->create([
            'user_id' => $user[1]->id,
            'balance' => 50
        ]);

        return [
            'users' => $user
        ];

    }
}