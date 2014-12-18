<?php

namespace Anax\Comments;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->comments = new \Anax\Comments\Comment();
        $this->comments->setDI($this->di);
    }
    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction()
    {   
        $comments = new \Anax\Comments\CommentsInSession($this->request->getPost('identifier'));
    
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
    public function viewImprovedAction()
    {
        $redirect = $this->di->request->getCurrentUrl();
        $identifier = $this->di->request->getCurrentUrl();

        $all = $this->comments->query()
            ->where('identifier = "'.$identifier.'"')
            ->execute();

        
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
    public function addAction($name = null, $homepage = null, $mail = null, $image = null, $content = null, $identifier = null, $redirect = null)
    {
        $now = date('y-m-d H:i:s');
        
        $this->comments->save([
            'name'           => $name,
            'homepage'       => $homepage,
            'email'          => $mail,
            'image'          => $image,
            'content'        => $content,
            'identifier'     => $identifier,
            'published'      => $now,
        ]);
        

        $this->response->redirect($redirect);
    }



    /**
     * Remove all comments.
     *
     * @return void
     */
    public function removeAllAction()
    {

        $this->comments->deleteAll();

        $this->response->redirect($this->request->getPost('redirect'));
    }

    public function editAction(){
            $id = $_GET['editId'];

            $comment = $this->comments->find($id);

            $this->di->dispatcher->forward(['controller' => 'form-edit-comment', 'action' => 'index', 'params' => ['comment' => $comment]]);
        
    }


    public function saveAction($name = null, $homepage = null, $mail = null, $image = null, $content = null, $identifier = null, $redirect = null, $id = null)
    {
        $comment = $this->comments->find($id);
        $comment->name = $name;
        $comment->homepage = $homepage;
        $comment->email = $mail;
        $comment->image = $image;
        $comment->content = $content;
        $comment->save();

        $this->response->redirect($redirect);
    }


    public function removeAction(){
        $id = $_GET['removeId'];

        $comment = $this->comments->find($id);
        $identifier = $comment->identifier;
        
        $res = $this->comments->delete($id);


        $this->response->redirect($this->url->create($identifier));

    }
}
