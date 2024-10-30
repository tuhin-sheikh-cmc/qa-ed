<?php

namespace App\Service\Questionnaire\Dtos;

use Symfony\Component\Validator\Constraints as Assert;

class QuestionRequestBody
{
    public function __construct(
        #[Assert\NotBlank]
        public string $questionnaire,

        public ?string $question
    ){
    }
}
