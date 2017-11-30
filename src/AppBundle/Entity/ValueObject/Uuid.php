<?php


namespace AppBundle\Entity\ValueObject;


use InvalidArgumentException;
use Ramsey\Uuid\Uuid as UuidGenerator;

class Uuid
{
    /**
     * @var string
     */
    private $id;

    public function __construct()
    {
        $this->id = (string) UuidGenerator::uuid4();
    }

    /**
     * @param string $uuid
     *
     * @return Uuid
     *
     * @throws InvalidArgumentException
     */
    public static function createFromExisting(string $uuid): self
    {
        if (!self::isValid($uuid)) {
            throw new InvalidArgumentException('Invalid Uuid');
        }

        $newUuid = new self();
        $newUuid->id = $uuid;

        return $newUuid;
    }

    /**
     * @param string $uuid
     *
     * @return bool
     */
    public static function isValid(string $uuid): bool
    {
        return UuidGenerator::isValid($uuid);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->id;
    }
}