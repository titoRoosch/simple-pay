<?php

namespace Tests\Feature;

use App\Models\User;
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
            "payer" => 4,
            "payee" => 15
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
            "payer" => 4,
            "payee" => 15
        ];

        $response = $this->makeRequest('post', '/api/transfer', $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(403);
    }

    public function testInvalidTrasnfer()
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken();


        $data = [
            "value" => 100.0,
            "payer" => 4,
            "payee" => 15
        ];

        $response = $this->makeRequest('post', '/api/transfer', $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(403);
    }

    public function testSucessCancelTransfer()
    {
        $mock = $this->mocks();
        $authData = $this->createUserAndGetToken();

        $data = [
            "value" => 100.0,
            "payer" => 4,
            "payee" => 15
        ];

        $response = $this->makeRequest('post', '/api/transfer/cancel', $authData['header'], $data);
        $content = $response->getContent();

        $responseData = json_decode($content, true);

        $response->assertStatus(200);
    }

    protected function mocks()
    {

    }
}