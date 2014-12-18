<?php
namespace Anax\Users;

class FormAddUserController
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    public function indexAction()
    {    
        //$this->di->session();

        $form = $this->di->form->create([], [
            'acronym' => [
                'type'        => 'text',
                'label'       => 'Akronym:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'name' => [
                'type'        => 'text',
                'label'       => 'Namn:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'mail' => [
                'type'        => 'text',
                'label'       => 'E-mail:',
                'required'    => false,
                'validation'  => ['not_empty', 'email_adress'],
            ],
            'password' => [
                'type'        => 'password',
                'label'       => 'Lösenord:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);


        $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);

        $this->di->views->add('teso/page', [
            'title' => "Register User",
            'content' => $form->getHTML()
        ]);
    }


    public function callbackSubmit($form)
    {

        return true;
    }


    public function callbackSuccess($form)
    {

        $form->saveInSession = true;
        //$form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        //$this->redirectTo();
        $this->di->dispatcher->forward(['controller' => 'users', 'action' => 'add', 'params' => [
            'acronym' => $form->Value('acronym'),
            'name' => $form->Value('name'),
            'mail' => $form->Value('mail'),
            'password' => $form->Value('password')
        ]]);
    }

    public function callbackFail($form)
    {
        $form->saveInSession = true;
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }
}
