<?php


namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /** @test */
    public function constructor()
    {
        $message = new Message('Test');

        $this->assertEquals('Test', $message->getContent());
    }
}