<?php

namespace App\Service\Questionnaire;

interface QuestionnaireInterface
{
    public function getQuestionnaire(string $jsonFile): void;
    public function getQuestion(string $key);
}