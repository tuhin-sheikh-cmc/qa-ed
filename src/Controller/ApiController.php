<?php

namespace App\Controller;

use App\Service\Questionnaire\QuestionnaireInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\Service\Questionnaire\Dtos\QuestionRequestBody;
use Exception;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

    #[Route('/api/v1/questionnaire', name: 'app_questionnaire')]
    public function questionnaire(
        QuestionnaireInterface $service,
        #[MapRequestPayload(
            acceptFormat: 'json'
        )] QuestionRequestBody $questionRequest
    ): JsonResponse {
        $questionnaires = $service->getQuestionnaire(
            $this->getJsonFileForQuestionnaire($questionRequest->questionnaire)
        );
        $question = $service->getQuestion($questionRequest->question);
        
        return $this->json($question);
    }

    private function getJsonFileForQuestionnaire(string $name): string
    {
        $jsonFile = sprintf(
            '%s/src/data/%s.json',
            $this->getParameter('kernel.project_dir'),
            $name
        );

        if (!file_exists($jsonFile)) {
            throw new Exception("Failed to find the file for questionnaire: ". $jsonFile);
        }

        return $jsonFile;
    }
}
