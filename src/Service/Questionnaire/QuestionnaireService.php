<?php

namespace App\Service\Questionnaire;

use Exception;
use App\Service\Questionnaire\Vos\QuestionnaireVo;

class QuestionnaireService implements QuestionnaireInterface
{
    public readonly QuestionnaireVo $vo;

    // read questions from a json file (or DB in future)

    // get specific questionnaire
    // we need to iterate over the file
    public function getQuestionnaire(string $jsonFile): void
    {
        if (!file_exists($jsonFile)) {
            throw new Exception("File not found: ". $jsonFile);
        }
        $jsonContent = file_get_contents($jsonFile);
        $jsonData = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode json data: ". json_last_error_msg());
        }
        $this->initQuestionnaire($jsonData);
    }

    public function getQuestion(string $key)
    {
        // get specific question using key
        return $this->vo->getQuestion($key);
    }

    private function initQuestionnaire(array $data) {
        //var_dump($data);
        $this->vo = new QuestionnaireVo($data['questions'], $data['products']);
    }
}
