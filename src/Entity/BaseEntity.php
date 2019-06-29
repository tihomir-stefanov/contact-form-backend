<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * Provides id and dates for all entities.
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class BaseEntity implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $dateUpdated;

    /**
     * @ORM\PrePersist
     * @throws \Exception
     */
    public function prePersist()
    {
        $now = new \DateTime('NOW', new \DateTimeZone('UTC'));
        $this->dateCreated = $now;
        $this->dateUpdated = $now;
    }

    /**
     * @ORM\PreUpdate
     * @throws \Exception
     */
    public function preUpdate()
    {
        $now = new \DateTime('NOW', new \DateTimeZone('UTC'));
        $this->dateUpdated = $now;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated(): DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * @param DateTimeInterface $dateCreated
     * @return BaseEntity
     */
    public function setDateCreated(DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdated(): DateTimeInterface
    {
        return $this->dateUpdated;
    }

    /**
     * @param DateTimeInterface $dateUpdated
     * @return BaseEntity
     */
    public function setDateUpdated(DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;
        return $this;
    }
}
