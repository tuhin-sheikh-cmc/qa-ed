<?php

namespace App\Controller;

use App\Service\Questionnaire\QuestionnaireInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

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
    public function questionnaire(QuestionnaireInterface $service): JsonResponse
    {
        $questionnaires = $service->getQuestionnaire('ed');
        return $this->json([
            "questions" => [
                [
                    "question" => "question 1",
                    "options" => [
                        "yes",
                        "no"
                    ],
                    "progress" => "continue"
                ],
            ]
        ]);
    }
}
