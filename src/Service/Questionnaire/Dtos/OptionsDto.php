<?php

namespace App\Service\Questionnaire\Dtos;

class OptionsDto
{
    public readonly array $exclude;
    public readonly string $nextStep;
    public readonly string $suggest;
    public readonly string $value;

    public function __construct(array $data)
    {
        $this->value = $data['value'];
        $this->nextStep = $data['next-step'] ?? '';
        $this->exclude = $data['exclude'] ?? [];
        $this->suggest = $data['suggest'] ?? '';
    }

    public function toArray(): array {
        $option = [];
        $option['value'] = $this->value;
        if (!empty($this->nextStep)) $option['next-step'] = $this->nextStep;
        if (!empty($this->exclude)) $option['exclude'] = $this->exclude;
        if (!empty($this->suggest)) $option['suggest'] = $this->suggest;

        return $option;
    }
}