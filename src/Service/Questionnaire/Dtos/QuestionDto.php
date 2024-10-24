<?php

namespace App\Service\Questionnaire\Dtos;
//use \Symfony\Component\Validator\Constraints as Assert;

class QuestionDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $question,
        public readonly array $options
    ) {}

    public function toArray(): array {
        $options = [];

        foreach ($this->options as $option) {
            $options[] = $option->toArray();
        }

        return $data = [
            $this->id => [
                "id" => $this->id,
                "question" => $this->question,
                "options" => $options
            ]
        ];
    }
}
