<?php

namespace AppBundle\Controller;

use AppBundle\Form\MessageData;
use AppBundle\Form\MessageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig', [
            'form' => $this->getForm()->createView()
        ]);
    }

    public function createAction(Request $request, \Swift_Mailer $mailer)
    {
//        die (print_r($request->request));

        $form = $this->getForm();

        $form->handleRequest($request);

        /** @var MessageData $data */
        $data = $form->getData();

        $this->email($mailer);

        return new Response($data->content);
    }

    private function email(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Test'))
            ->setFrom('test@test.pl')
            ->setTo('test2@test.pl')
            ->setBody('Testowa wiadomość')
        ;

        $mailer->send($message);
    }

    public function testAction(Request $request)
    {
        return new Response('Test!');
    }

    private function getForm(): FormInterface
    {
        return $this->createForm(MessageFormType::class);
    }
}
