<?php

namespace App\Service\Questionnaire\Vos;

use App\Service\Questionnaire\Dtos\OptionsDto;
use \App\Service\Questionnaire\Dtos\QuestionDto;

/**
 * We could have skipped this for the test, but it's here to allow editing
 * (questionnaires) if it is implemented in future.
 */
class QuestionnaireVo
{
    /** @var QuestionDto[] $questions */
    private array $questions;

    public function __construct(
        array $questions,
        public readonly array $products
    ) {
        foreach ($questions as $question) {
            $options = [];
            foreach ($question['options'] as $data) {
                $options[] = new OptionsDto($data);
            };
            $this->questions[] = new QuestionDto($question['id'], $question['question'], $options);
        }
    }

    public function getQuestion(string $key) {
        /** @var QuestionDto $question */
        foreach ($this->questions as $entry) {
            if ($entry->id === $key) {
                return $entry;
            }
        }
    }
}
