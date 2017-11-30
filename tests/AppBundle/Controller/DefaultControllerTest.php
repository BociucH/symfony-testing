<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\SwiftmailerBundle\DataCollector\MessageDataCollector;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /** @test */
    public function index()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    /** @test */
    public function menuRendering()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(1, $crawler->filter('a.active')->count());
        $this->assertTrue($crawler->filter('body > a')->count() === 1);
    }

    /** @test */
    public function formRendering()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertTrue($crawler->filter('form[name="message_form"]')->count() > 0);
    }

    /** @test */
    public function link()
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Test')->link();
        $crawler = $this->client->click($link);

        $this->assertTrue($crawler->filter('body:contains("Test!")')->count() > 0);
    }

    /** @test */
    public function form()
    {
        $this->client->enableProfiler();

        $crawler = $this->client->request('GET', '/');

        $token = $this->client->getContainer()
            ->get('security.csrf.token_manager')
            ->getToken('message')
            ->getValue()
        ;

        $form = $crawler->filter('form[name="message_form"]')->form();
        $form['message_form[content]'] = 'Asdas adasdz';
        $form['message_form[_token]'] = $token;
        $crawler = $this->client->submit($form);

        /** @var MessageDataCollector $mailCollector */
        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');

        $this->assertEquals(1, $mailCollector->getMessageCount());

        /** @var \Swift_Message $message */
        $message = $mailCollector->getMessages()[0];

        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('Test', $message->getSubject());
        $this->assertEquals('test@test.pl', key($message->getFrom()));
        $this->assertEquals('test2@test.pl', key($message->getTo()));
        $this->assertEquals('Testowa wiadomość', $message->getBody());
    }

    /** @test */
    public function locale()
    {
        $crawler = $this->client->request('GET', '/');

        $locale = $this->client->getRequest()->getLocale();

        $this->assertEquals('en', $locale);
    }
}
