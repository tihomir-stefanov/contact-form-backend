<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class BaseController
 * @package App\Controller
 */
class BaseController extends AbstractController
{
    /**
     * @param array $data
     * @param array $context
     * @return JsonResponse
     */
    protected function success($data = [], array $context = []): JsonResponse
    {
        $response = [
            'code' => 0,
            'status' => 'success',
            'data' => $data
        ];
        return parent::json($response, 200, [], $context);
    }
}
