<?php

namespace App\Service\Questionnaire\Vos;

use App\Service\Questionnaire\Dtos\OptionsDto;
use App\Service\Questionnaire\Dtos\QuestionDto;

/**
 * handle question level data in this Value Object
 */
class QuestionVo
{
    private QuestionDto $question;

    public function __construct(array $question) {
        $options = [];
        
        foreach ($question['options'] as $data) {
            $options[] = new OptionsDto($data);
        }

        $this->question = new QuestionDto($question['id'], $question['question'], $options);
    }
}
