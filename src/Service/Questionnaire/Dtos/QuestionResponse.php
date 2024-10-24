<?php

namespace App\Service\Questionnaire\Dtos;

class QuestionResponse
{
    public function __construct(
        public readonly string $question,
        public readonly array $options,
        public readonly string $progress
    ) {
        //
    }

    public function fromArray(array $array): self
    {
        return new QuestionResponse(...$array);
    }
}
