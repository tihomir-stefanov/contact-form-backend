<?php

namespace App\Service;

use App\Exception\AppException;
use App\Exception\Exceptions;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorService
 * @package App\Service
 */
class ValidatorService
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * ValidatorService constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param $object
     * @param array $groups
     * @throws AppException
     */
    public function validate($object, array $groups = []): void
    {
        $errors = $this->validator->validate($object, null, $groups);
        if (count($errors) > 0) {
            $data = [];
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
                $data[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new AppException(Exceptions::VALIDATION_ERROR, $messages[0], $data);
        }
    }
}
