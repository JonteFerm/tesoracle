<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction()
    {   
        $comments = new \Phpmvc\Comment\CommentsInSession($this->request->getPost('identifier'));
        $comments->setDI($this->di);

        $all = $comments->findAll();

        $this->views->add('comment/comments', [
            'comments' => $all,
            'redirect' => $this->request->getPost('redirect'),
        ]);
    }

    /**
    * Shows the improved view from comments_me.
    *
    * @return void
    */
    public function viewImprovedAction($identifier = null,$redirect = null)
    {
        $comments = new \Phpmvc\Comment\CommentsInSession($identifier);
        $comments->setDI($this->di);

        $all = $comments->findAll();

        $this->views->add('comment/comments_me', [
            'comments' => $all,
            'redirect' => $redirect,
            'identifier' => $identifier,
        ]);
    }


    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction()
    {
        $isPosted = $this->request->getPost('doCreate');
        
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comment = [
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'image'     => $this->request->getPost('image'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),

        ];

        $comments = new \Phpmvc\Comment\CommentsInSession($this->request->getPost('identifier'));
        $comments->setDI($this->di);

        $comments->add($comment);

        $this->response->redirect($this->request->getPost('redirect'));
    }



    /**
     * Remove all comments.
     *
     * @return void
     */
    public function removeAllAction()
    {
        $isPosted = $this->request->getPost('doRemoveAll');
        
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession($this->request->getPost('identifier'));
        $comments->setDI($this->di);

        $comments->deleteAll();

        $this->response->redirect($this->request->getPost('redirect'));
    }

    public function editAction(){
            $commentId = $_GET['editId'];
            $comments = new \Phpmvc\Comment\CommentsInSession($_GET['identifier']);
            $comments->setDI($this->di);
            $all = $comments->findAll();
            $comment = $all[$commentId];
            $this->views->add('comment/edit', [
                'comment' => $comment,
                'commentId' => $commentId,
                'redirect' => $_GET['redirect'],
                'identifier' => $_GET['identifier'],
            ]);
        
    }

    public function saveAction(){
        $isPosted = $this->request->getPost('doSave');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

            
        $comments = new \Phpmvc\Comment\CommentsInSession($this->request->getPost('identifier'));
        $comments->setDI($this->di);
        $all = $comments->findAll();
        $editId = $this->request->getPost('id');
        $all[$editId]['content'] = $this->request->getPost('content');
        $all[$editId]['name'] = $this->request->getPost('name');
        $all[$editId]['web'] = $this->request->getPost('web');
        $all[$editId]['mail'] = $this->request->getPost('mail');
        $all[$editId]['image'] = $this->request->getPost('image');
        $comments->replaceAll($all);

        $this->response->redirect($this->request->getPost('redirect'));
    }

    public function removeAction(){
        $commentId = $_GET['removeId'];
        $comments = new \Phpmvc\Comment\CommentsInSession($_GET['identifier']);
        $comments->setDI($this->di);
        $all = $comments->findAll();
        unset($all[$commentId]);
        $comments->replaceAll($all);
        $this->response->redirect($this->url->create($_GET['redirect']));

    }
}
