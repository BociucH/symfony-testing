<?php


namespace Tests\AppBundle\Entity\ValueObject;


use AppBundle\Entity\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    /**
     * @var Uuid
     */
    private $uuid;

    public function setUp()
    {
        $this->uuid = new Uuid();
    }

    /** @test */
    public function constructor()
    {
        $this->assertInternalType('string', (string) $this->uuid);
    }

    /** @test */
    public function isValid()
    {
        $this->assertTrue(Uuid::isValid($this->uuid));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function createFromExistingException()
    {
        $uuid = Uuid::createFromExisting('asdv-22zx');
    }

    /** @test */
    public function createFromExisting()
    {
        $uuid = Uuid::createFromExisting('aa431f77-3679-4728-82f4-6bc41e8aefdf');

        $this->assertTrue(Uuid::isValid($uuid));
    }
}