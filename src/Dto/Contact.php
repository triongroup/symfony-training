<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Contact {
    #[Assert\NotBlank()]
    private string $name;

    #[Assert\Email()]
    #[Assert\NotBlank()]
    private string $email;
    #[Assert\NotBlank()]
    private string $subject;
    #[Assert\NotBlank()]
    private string $message;

    public function __construct(
        string $name = null,
        string $email = null,
        string $subject = null,
        string $message = null
    ) {}

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getSubject(): string {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void {
        $this->message = $message;
    }

}