<?php

namespace App\Tests\Unit\Controller;

use \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use \App\Controller\ApiController;
use App\Service\Questionnaire\QuestionnaireInterface;
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
        $this->apiClass->questionnaire($this->service);
        $jsonFile = $this->container->get('kernel')->getProjectDir() . '/src/data/ed.json';
        $this->apiClass->getQuestionnaire($jsonFile);
        $response = $this->apiClass->getQuestion('q1');
        $this->assertInstanceOf(JsonResponse::class, $response, "Returned response is not instance of JsonResponse");
        $this->assertJsonStringEqualsJsonString('{"questions":[{"question":"question 1","options":["yes","no"],"progress":"continue"}]}', $response->getContent());
    }
}
