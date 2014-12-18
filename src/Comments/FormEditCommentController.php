<?php

namespace Anax\Comments;

class FormEditCommentController
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    public function indexAction($comment)
    {    

        $this->di->session();

        $form = $this->di->form->create([], [
            'redirect' => [
                'type'        => 'hidden',
                'required'    => true,
                'value'       => $comment->identifier,
                'validation'  => ['not_empty'],
            ],
            'identifier' => [
                'type'        => 'hidden',
                'required'    => true,
                'value'       => $this->di->request->getCurrentUrl(),
                'validation'  => ['not_empty'],
            ],
            'id' => [
                'type'        => 'hidden',
                'value'       => $comment->id,
                'required'    => true,
                'validation'  => ['not_empty'],
            ],

            'content' => [
                'type'        => 'textarea',
                'label'       => 'Comment:',
                'value'       => $comment->content,
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'name' => [
                'type'        => 'text',
                'label'       => 'Namn:',
                'value'       => $comment->name,
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            'homepage' => [
                'type'        => 'text',
                'label'       => 'Homepage:',
                'value'       => $comment->homepage,
                'required'    => false,
            ],
            'mail' => [
                'type'        => 'text',
                'label'       => 'E-mail:',
                'value'       => $comment->email,
                'required'    => true,
                'validation'  => ['not_empty','email_adress'],
            ],
            'image' => [
                'type'        => 'text',
                'label'       => 'Image:',
                'value'       => $comment->image,
                'required'    => false,
            ],
            'save' => [
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
        $this->di->dispatcher->forward(['controller' => 'comment', 'action' => 'save', 'params' => [
            'name' => $form->Value('name'),
            'homepage' => $form->Value('homepage'),
            'mail' => $form->Value('mail'),
            'image' => $form->Value('image'),
            'content' => $form->Value('content'),
            'identifier' => $form->Value('identifier'),
            'redirect' => $form->Value('redirect'),
            'id' => $form->Value('id')
        ]]);
    }

    public function callbackFail($form)
    {
        $form->saveInSession = true;
        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }
}
