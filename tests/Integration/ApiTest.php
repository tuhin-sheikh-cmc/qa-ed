<?php

namespace App\Tests\Integration;

use \Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @covers App\Controller\ApiController
 */
class ApiTest extends WebTestCase
{
    private $client;
    protected function setUp(): void
    {
        //$this->client = static::getClient();
        $this->client = static::createClient();
    }

    public function testApiResponse(): void
    {
        $response = $this->client->request('GET', '/api/v1/questionnaire');

        $this->assertResponseIsSuccessful();
        $this->assertContains('"progress" => "continue"', $response->getContent(), "Failed to find string in response");
        //$this->assertJsonContains(['status' => 'ok']);
    }
}
