<?php declare(strict_types = 1);

namespace Dravencms\Database\Attributes;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SoftDeleteableEntity
{
    /**
     * @var \DateTime|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected $deletedAt;

    /**
     * @return $this
     */
    public function setDeletedAt(?\DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function isDeleted(): bool
    {
        return null !== $this->deletedAt;
    }
}
