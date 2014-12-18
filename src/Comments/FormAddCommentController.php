<?php

namespace Anax\Comments;

class FormAddCommentController
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    public function indexAction()
    {    
        $this->di->session();

        $form = $this->di->form->create([], [
            'redirect' => [
                'type'        => 'hidden',
                'required'    => true,
                'value'       => $this->di->request->getCurrentUrl(),
                'validation'  => ['not_empty'],
            ],
            'identifier' => [
                'type'        => 'hidden',
                'required'    => true,
                'value'       => $this->di->request->getCurrentUrl(),
                'validation'  => ['not_empty'],
            ],
            'content' => [
                'type'        => 'textarea',
                'label'       => 'Comment:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'name' => [
                'type'        => 'text',
                'label'       => 'Namn:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'homepage' => [
                'type'        => 'text',
                'label'       => 'Homepage:',
                'required'    => false,
            ],
            'mail' => [
                'type'        => 'text',
                'label'       => 'E-mail:',
                'required'    => true,
                'validation'  => ['not_empty','email_adress'],
            ],
            'image' => [
                'type'        => 'text',
                'label'       => 'Image:',
                'required'    => false,
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);


        $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);

        $this->di->views->add('me/page', [
            'title' => "Kommentera",
            'content' => $form->getHTML()
        ]);
    }


    public function callbackSubmit($form)
    {   
        return true;
    }

    public function callbackSuccess($form)
    {
        $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");

     
         $this->di->dispatcher->forward(['controller' => 'comment', 'action' => 'add', 'params' => [
            'name' => $form->Value('name'),
            'homepage' => $form->Value('homepage'),
            'mail' => $form->Value('mail'),
            'image' => $form->Value('image'),
            'content' => $form->Value('content'),
            'identifier' => $form->Value('identifier'),
            'redirect' => $form->Value('redirect')
        ]]);
        
    }

    public function callbackFail($form)
    {
        $form->saveInSession = false;
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }
}
