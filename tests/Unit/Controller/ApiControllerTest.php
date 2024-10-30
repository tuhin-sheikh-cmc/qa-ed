<?php

namespace App\Tests\Unit\Controller;

use \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use \App\Controller\ApiController;
use \App\Service\Questionnaire\QuestionnaireInterface;
use \App\Service\Questionnaire\Dtos\QuestionRequestBody;
use \Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @covers App\Controller\ApiController
 */
//class ApiControllerTest extends TestCase
class ApiControllerTest extends KernelTestCase
{
    private $apiClass;
    private $container;
    private $service;

    protected function setUp(): void
    {
        $this->container = static::getContainer();
        $this->apiClass = $this->container->get(ApiController::class);
        $this->service = $this->container->get(QuestionnaireInterface::class);
    }

    
    public function testApiController(): void
    {
        $response = $this->apiClass->index();
        
        $this->assertNotEmpty($response);
        $this->assertInstanceOf(JsonResponse::class, $response, "Returned response is not instance of JsonResponse");
        /** @var JsonResponse $response */
        $this->assertEquals(200, $response->getStatusCode(), "status code should be 200");
        $this->assertJson($response->getContent());
    }

    /**
     * @group test
     */
    public function testQuestionnaires(): void
    {
        $request = new QuestionRequestBody("ed","");
        $response = $this->apiClass->questionnaire($this->service, $request);

        $this->assertInstanceOf(JsonResponse::class, $response, "Returned response is not instance of JsonResponse");
        $this->assertJsonStringEqualsJsonString('{"id":"q1","question":"Do you have difficulty getting or maintaining an erection?","options":[{"value":"Yes","exclude":[],"nextStep":"q2","suggest":""},{"value":"No","nextStep":"end","exclude":["all"],"suggest":""}]}', $response->getContent());
    }
}
