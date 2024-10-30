<?php

namespace App\Tests\Integration;

use \Symfony\Component\HttpClient\CurlHttpClient;
use \Symfony\Contracts\HttpClient\HttpClientInterface;
use \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers App\Controller\ApiController
 */
class ApiTest extends KernelTestCase
{
    private HttpClientInterface $client;

    protected function setUp(): void
    {
        $this->client = new CurlHttpClient();
    }

    /**
     * @test
     */
    public function errorThrownWhenRequestIsInGetMethod(): void
    {
        $response = $this->client->request('GET', 'http://localhost:8899/api/v1/questionnaire');
        $this->assertEquals(415, $response->getStatusCode(), "GET request should return 415");
    }

    /**
     * @test
     */
    public function errorThrownWhenRequestMadeWithoutPayload(): void
    {
        $response = $this->client->request('POST', 'http://localhost:8899/api/v1/questionnaire',[
            'headers' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        ]);

        $this->assertEquals(422, $response->getStatusCode(), "GET request should return 415");
    }

    /**
     * @test
     */
    public function errorThrownWhenRequestPayloadIsInvalid(): void
    {
        $response = $this->client->request('POST', 'http://localhost:8899/api/v1/questionnaire',[
            'headers' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            'body' => '{}'
        ]);

        $this->assertEquals(422, $response->getStatusCode(), "GET request should return 415");
    }

    /**
     * @test
     */
    public function returnsValidDataOnRequestToReturnSpecificQuestion(): void
    {
        $response = $this->client->request('POST', 'http://localhost:8899/api/v1/questionnaire',[
            'headers' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            'body' => '{"questionnaire": "ed", "question": "q2a"}'
        ]);

        $this->assertEquals(200, $response->getStatusCode(), "Status code 200 expected.");
        $this->assertEquals('application/json', $response->getHeaders()['content-type'][0], "Content-Type header should be application/json");
        $this->assertJsonStringEqualsJsonString('{"id":"q2a","question":"Was the Viagra or Sildenafil product you tried before effective?","options":[{"value":"Yes","suggest":"sld50","exclude":[],"nextStep":"q3"},{"value":"No","suggest":"tdl20","exclude":[],"nextStep":"q3"}]}', $response->getContent(), "Json response did not match with expected");
    }

    /**
     * @test
     */
    public function returnsFirstQuestionWhenNoQuestionSpecified(): void
    {
        $response = $this->client->request('POST', 'http://localhost:8899/api/v1/questionnaire',[
            'headers' => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            'body' => '{"questionnaire": "ed"}'
        ]);

        $this->assertEquals(200, $response->getStatusCode(), "Status code 200 expected.");
        $this->assertEquals('application/json', $response->getHeaders()['content-type'][0], "Content-Type header should be application/json");
        $this->assertJsonStringEqualsJsonString('{"id":"q1","question":"Do you have difficulty getting or maintaining an erection?","options":[{"value":"Yes","exclude":[],"nextStep":"q2","suggest":""},{"value":"No","nextStep":"end","exclude":["all"],"suggest":""}]}', $response->getContent(), "Json response did not match with expected");
    }
}
