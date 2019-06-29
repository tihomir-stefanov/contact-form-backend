<?php


namespace App\Tests\Integration\Manager;


use App\Dto\ContactFormDto;
use App\Entity\ContactForm;
use App\Exception\AppException;
use App\Manager\ContactFormManager;
use App\Tests\Integration\BaseIntegrationTest;

class ContactFormManagerTest extends BaseIntegrationTest
{
    /** @var ContactFormManager */
    private $contactFormManager;

    protected function setUp()
    {
        parent::setUp();

        $this->contactFormManager = self::$container->get('test.App\Manager\ContactFormManager');
    }

    /**
     * @throws AppException
     */
    public function testValidData()
    {
        $dto = new ContactFormDto();
        $dto->setEmail('valid@email.com');
        $dto->setMessage('Valid message');
        $this->contactFormManager->submit($dto);

        $entities = self::$em->getRepository(ContactForm::class)->findAll();

        $this->assertEquals(1, count($entities));
    }

    /**
     * @throws AppException
     */
    public function testMissingEmail()
    {
        $this->expectException(AppException::class);

        $dto = new ContactFormDto();
        $dto->setMessage('Valid message');
        $this->contactFormManager->submit($dto);
    }

    /**
     * @throws AppException
     */
    public function testMissingMessage()
    {
        $this->expectException(AppException::class);

        $dto = new ContactFormDto();
        $dto->setEmail('valid@email.com');
        $this->contactFormManager->submit($dto);
    }

    /**
     * @dataProvider getInvalidData
     * @param string $email
     * @param string $message
     * @throws AppException
     */
    public function testInvalidData(string $email, string $message)
    {
        $this->expectException(AppException::class);

        $dto = new ContactFormDto();
        $dto->setEmail($email);
        $dto->setMessage($message);
        $this->contactFormManager->submit($dto);
    }

    /**
     * @return array
     */
    public function getInvalidData()
    {
        return [
            ['not-actual-email', 'Valid message'],
            ['', 'Valid message'],
            ['long_email1NL2q52MnF8MNvC6rnPJlHw5tHiF71qaE6xmRCuwT1p7TgiZNmxlYpwsl9nhsFHoInfiV0JwuSIqld36lKp3uD69FHbu3NyPzwamb3YZf34FwnGzoexk5R9UsjAKJa51D63IM8xfxhstH9E8uwR8YPP7aPrSlyx4ZD4yf5vAoI7E4T1hRYdEyf6Vj3dF8V5a5uPiynEC7HyBJI7gMbvPTfIlEMA0MfF8cO47QvvO2c1QsCuIxQRI@long.com', 'Valid message'],
            ['valid@email.com', ''],
            ['valid@email.com', '1001_HVSZrWa27Sj8mur6HXGGL6BBfJ3cn2zhrQVaoLL5omlbQT4uz3YMr1dzFLwpV85LBoUNEGfEEeIcbewQPJZK8N1b5tDZfiWk2n3qEYx93MDSAqrtY3RjqvbpL8NF69ysrS2bG30inOo1Us7ImCZYegustdALG2okrXpnYfoNGflEOJioUIJIobvelEaLjYLag0uGv7SjzO2CZZ57MLW0eY4OpvUzNNTb1jB3fuiy2VFr0iblelQzoeM2yv8wi2TuxZC7UbSaYyCvqUmTw4kTxXU3tRCWJh0RHpum4JdeZQdZdaItoWBAFKRpfPpIb9HKYT4qkyNebQYGloGg2Ut8H3vQTa1M9s49D85rXsKjfKK2IdG6K2L6blwSCcZt5GwKCRjY5miTThD8Lxv0h6xFWBTe0yVSyJsBbY2tWdgZ033XhMvKbntI8E5XmhOgvV0UYcasnExXk7o6ugrMGMP4eycuhZy4v2V0CBjHW1qsg33fC0Pw8kXfFMHtx0AEgozW4QDwNqTqg51sDZnqiXUTJlm7o5yd3EoF1F6w02O665hqgzULQfmZh7eaCJEh85C1fnX2ybdgDVLczXyTSlTvFZt5kB8GkOyEMVvdepYE7Mqa0RXLbFhgf81g5xQCZ3YSqKRkkbrC650yw2HLMR6KQYb11Ty5qnXSzuHFzhekMIslYjS4lKYiGXt60oYvPQ2Mpve3mXaNoJ6ezIgKggIcJrESxGpcHyjDuIsIBWFRJNjPYBQDNMo0ZjArAIoHmnFFMAjq6ueQ8wCBFkqhtGrD0NMXuRsPYk72W1aeVaJ2tA82jyXuZihiAIHF5Lcu8S3k6aVHE6pcMJ0XiWI6vxpAkpURMvYTbXeofifhwYBxBBZJCdHssX22zluMdW7kQiVxTlo0BHE1gJE2kHl91sxFoK2wuU4MPljH5brFcjQcUV8Edf1TaETiWWn3jP94Qn0czByfmVABaEDzDjGAyc8MOWrMyN8EGasCQf3F'],
        ];
    }
}
