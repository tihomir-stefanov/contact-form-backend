<?php

namespace App\Manager;

use App\Dto\ContactFormDto;
use App\Entity\ContactForm;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ContactFormManager
 * @package App\Manager
 */
class ContactFormManager
{
    /**
     * @var ValidatorService
     */
    private $validatorService;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ContactFormManager constructor.
     * @param ValidatorService $validatorService
     * @param EntityManagerInterface $em
     */
    public function __construct(
        ValidatorService $validatorService,
        EntityManagerInterface $em
    )
    {
        $this->validatorService = $validatorService;
        $this->em = $em;
    }

    /**
     * @param ContactFormDto $dto
     * @throws \App\Exception\AppException
     */
    public function submit(ContactFormDto $dto): void
    {
        $this->validatorService->validate($dto);

        $contactForm = new ContactForm();
        $contactForm->setEmail($dto->getEmail());
        $contactForm->setMessage($dto->getMessage());

        $this->em->persist($contactForm);
        $this->em->flush();
    }

}
