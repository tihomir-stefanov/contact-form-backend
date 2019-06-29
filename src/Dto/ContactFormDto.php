<?php
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class ContactFormDto
{
    /**
     * @var string
     * @Assert\NotBlank(message="Please fill up the email address")
     * @Assert\Email(message="Email not valid")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "The email must be at least {{ limit }} characters long",
     *      maxMessage = "The email cannot be longer than {{ limit }} characters"
     * )
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(message="Please fill up the message")
     * @Assert\Length(
     *      min = 1,
     *      max = 1000,
     *      minMessage = "The message must be at least {{ limit }} characters long",
     *      maxMessage = "The message cannot be longer than {{ limit }} characters"
     * )
     */
    private $message;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

}
