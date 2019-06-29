<?php


namespace App\Controller;


use App\Dto\ContactFormDto;
use App\Manager\ContactFormManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ContactFormController
 * @package App\Controller
 */
class ContactFormController extends BaseController
{
    /**
     * @var ContactFormManager
     */
    private $contactFormManager;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ContactFormController constructor.
     * @param ContactFormManager $contactFormManager
     * @param SerializerInterface $serializer
     */
    public function __construct(
        ContactFormManager $contactFormManager,
        SerializerInterface $serializer
    )
    {
        $this->contactFormManager = $contactFormManager;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \App\Exception\AppException
     */
    public function submit(Request $request)
    {
        $content = $request->getContent();
        /** @var ContactFormDto $dto */
        $dto = $this->serializer->deserialize($content, ContactFormDto::class, 'json');
        $this->contactFormManager->submit($dto);

        return $this->success();
    }
}
