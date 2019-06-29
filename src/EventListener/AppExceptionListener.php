<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use App\Exception\AppException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Kernel;
use Psr\Log\LoggerInterface;


/**
 * Class AppExceptionListener
 * @package App\EventListener
 */
class AppExceptionListener
{
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AppExceptionListener constructor.
     * @param Kernel $kernel
     * @param LoggerInterface $logger
     */
    public function __construct(Kernel $kernel, LoggerInterface $logger)
    {
        $this->kernel = $kernel;
        $this->logger = $logger;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $env = $this->kernel->getEnvironment();

        // You get the exception object from the received event
        $exception = $event->getException();

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof AppException) {

            $this->logger->warning('AppException' . $exception);

            $data = json_decode($exception->getMessage(), true);
            $err = [
                'status' => 'error',
                'code' => $exception->getCode(),
                'message' => $data['message'],
                'data' => $data['data']
            ];

            $response = new JsonResponse($err, 200);
            $event->setResponse($response);
            $event->setException(new HttpException(200));
        } else {
            $this->logger->error('Exception' . $exception);
            if ($env !== 'dev') {
                $err = [
                    'status' => 'error',
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage()
                ];
                $response = new JsonResponse($err, 200);
                $event->setResponse($response);
                $event->setException(new HttpException(200));
            }
        }

    }
}
