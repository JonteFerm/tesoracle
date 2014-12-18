<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentsInSession implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    private $identifier;

    public function __construct($identifier){
        $this->identifier = $identifier;
    }


    /**
     * Add a new comment.
     *
     * @param array $comment with all details.
     * 
     * @return void
     */
    public function add($comment)
    {
        $comments = $this->session->get('comments_'.$this->identifier, []);
        $comments[] = $comment;
        $this->session->set('comments_'.$this->identifier, $comments);
    }

    public function replaceAll($comments){
        $this->session->set('comments_'.$this->identifier, $comments);
    }


    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findAll()
    {
        return $this->session->get('comments_'.$this->identifier, []);
    }


    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteAll()
    {
        $this->session->set('comments_'.$this->identifier, []);
    }


}
