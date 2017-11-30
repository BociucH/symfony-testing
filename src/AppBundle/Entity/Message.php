<?php

namespace AppBundle\Entity;


use AppBundle\Entity\ValueObject\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Message
{
    /**
     * @ORM\Column(type="uuid")
     * @var Uuid
     */
    private $id;

    /**
     * @ORM\Column()
     * @var string
     */
    private $content;

    /**
     * Message constructor.
     *
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}