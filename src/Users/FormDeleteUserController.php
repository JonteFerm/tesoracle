<?php

namespace Anax\Users;

class FormDeleteUserController
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    public function indexAction()
    {
        //$this->di->session();

        $form = $this->di->form->create([], [
            'deleteAcronym' => [
                'type'        => 'text',
                'label'       => 'Akronym:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'deletePassword' => [
                'type'        => 'password',
                'label'       => 'Lösenord:',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'submit' => [
                'type'      => 'submit',
                'value'     => 'Delete',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);


        $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);

        $this->di->views->add('me/page', [
            'title' => "Ta bort användare",
            'content' => $form->getHTML()
        ]);
    }


    public function callbackSubmit($form)
    {
        //$form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
        return true;
    }

    public function callbackSuccess($form)
    {
        //$form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
        $form->saveInSession = false;
        $this->di->dispatcher->forward(['controller' => 'users', 'action' => 'delete', 'params' => [
            'acronym' => $form->Value('deleteAcronym'),
            'password' => $form->Value('deletePassword')
        ]]);
    }

    public function callbackFail($form)
    {
        $form->saveInSession = true;
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }
}
