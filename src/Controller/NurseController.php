<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class NurseController extends AbstractController
{
    #[Route('/nurse', name: 'app_nurse')]
    public function index(): JsonResponse
    {
        $json_nurse = file_get_contents('DATA.json');
        $json_data = json_decode($json_nurse, true);
        // Retorna los datos como una respuesta JSON
        return new JsonResponse($json_data);
    }

    #[Route('/nurse/filter', name: 'app_nurse_filter', methods: ['GET'])]
    public function filterByName(Request $request): JsonResponse
    {
        $json_nurse = file_get_contents('DATA.json');
        $json_data = json_decode($json_nurse, true);
    
        // Obtener el nombre del parámetro de consulta
        $name = $request->query->get('first_name');
    
        // Filtrar los enfermeros por nombre usando array_filter
        $filtered_nurses = array_filter($json_data, function($nurse) use ($name) {
            return strtolower($nurse['first_name']) === strtolower($name);
        });
    
        // Retornar los enfermeros filtrados como respuesta JSON
        return new JsonResponse(array_values($filtered_nurses));
    }
}
