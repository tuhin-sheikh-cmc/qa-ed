<?php

namespace App\Tests\Unit\Service\Questionnaire;

use \App\Service\Questionnaire\QuestionnaireInterface;
use \Exception;
use \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuestionnaireServiceTest extends KernelTestCase
{
    private $container;
    private QuestionnaireInterface $serviceClass;

    protected function setUp(): void
    {
        $this->container = static::getContainer();
        $this->serviceClass = $this->container->get(QuestionnaireInterface::class);
    }

    /**
     * @test
     * @group service
     * @covers QuestionnaireService::getQuestionnaire()
     */
    public function throwsErrorWhenFileNotFound(): void
    {
        $this->expectException(\Exception::class);
        $this->serviceClass->getQuestionnaire('with-some-invalid-file.json');
        $this->expectExceptionMessage("File not found: ");
    }

    /**
     * @test
     * @group service
     * @covers QuestionnaireService::getQuestionnaire()
     */
    public function throwsErrorWhenJsonIsInvalid(): void
    {
        $this->expectException(\Exception::class);
        $jsonFile = $this->container->get('kernel')->getProjectDir() . '/tests/Unit/fixtures/questionnaire-service-invalid-json.json';
        $this->serviceClass->getQuestionnaire($jsonFile);
    }

    /**
     * @group service
     * @covers QuestionnaireService::getQuestionnaire()
     */
    public function testQuestionReturnsValidResponse(): void
    {
        $jsonFile = $this->container->get('kernel')->getProjectDir() . '/src/data/ed.json';
        $this->serviceClass->getQuestionnaire($jsonFile);
        $question = $this->serviceClass->getQuestion('q1');
        $this->assertJsonStringEqualsJsonString('{"q1":{"id":"q1","question":"Do you have difficulty getting or maintaining an erection?","options":[{"value":"Yes","next-step":"q2"},{"value":"No","next-step":"end","exclude":["all"]}]}}', json_encode($question->toArray()), "Question did not match with expected.");
    }
}
