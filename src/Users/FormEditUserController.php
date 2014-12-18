<?php
namespace Anax\Users;

class FormEditUserController
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    private $user = null;

    public function indexAction($user = null)
    {    
        $this->user = $user;

        $form = $this->di->form->create([], [
            'name' => [
                'type'        => 'text',
                'label'       => 'Name:',
                'value'       => $user->name,
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'mail' => [
                'type'        => 'text',
                'label'       => 'E-mail:',
                'value'       => $user->email,
                'required'    => false,
                'validation'  => ['not_empty', 'email_adress'],
            ],
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmit'],
            ],
        ]);


        $form->check([$this, 'callbackSuccess'], [$this, 'callbackFail']);

        $this->di->views->add('teso/page', [
            'title' => "Edit user: ".$user->acronym,
            'content' => $form->getHTML()
        ]);
    }


    public function callbackSubmit($form)
    {
        return true;
    }


    public function callbackSuccess($form)
    {
        $now = date('y-m-d H:i:s');
        $this->user->name = $form->Value('name');
        $this->user->email = $form->Value('mail');
        $this->user->updated = $now;
        $this->user->save();
        $this->redirectTo('users/id/'.$this->user->id);
    }

    public function callbackFail($form)
    {
        $form->saveInSession = true;
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }
}
