<?php

namespace App\Tests\Unit\Questionnaire\Vos;

use App\Service\Questionnaire\Dtos\OptionsDto;
use App\Service\Questionnaire\Vos\QuestionnaireVo;
use PHPUnit\Framework\TestCase;

class QuestionnaireVoTest extends TestCase
{
    /**
     * @group service
     * @group vo
     * @covers QuestionnaireVo::getQuestion()
     */
    public function testSomething(): void
    {
        $vo = new QuestionnaireVo([
            "q1" => [
                "id" => "q1",
                "question" => "Question 1",
                "options" => [
                    [
                        "value" => "Yes",
                        "next-value" => "q2"
                    ],
                    [
                        "value" => "No",
                        "next-value" => "end"
                    ]
                ]
            ]
        ],[
            "product" => "product 1"
        ]);
        /** @var QuestionVo $question */
        $question = $vo->getQuestion("q1");
        $this->assertTrue(in_array("product 1", $vo->products), "Product not found in array");
        $this->assertNotEmpty($question);
        $this->assertEquals("q1", $question->id, "ID did not match with expected id");
        $this->assertEquals("Question 1", $question->question, "Question did not match with expected value");
        $this->assertEquals(2, count($question->options), "There should be 2 options");
        $this->assertInstanceOf(OptionsDto::class, $question->options[0], "Options should be instance of OptionsDto");
        $this->assertEquals("No", $question->options[1]->value, "Second options should have value 'No'");
    }
}
