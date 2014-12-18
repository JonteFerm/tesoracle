<?php
namespace Anax\Users;

class UsersController implements \Anax\DI\IInjectionAware
{
	use \Anax\DI\TInjectable;

	public function initialize()
	{
	    $this->users = new \Anax\Users\User();
	    $this->users->setDI($this->di);
	}

	public function listAction(){
		$all = $this->users->findAll();
		$this->theme->setTitle("List all users");

	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "View all users",
	    ]);
	}

	public function idAction($id = null)
	{
	    $user = $this->users->find($id);
	    $this->theme->setTitle("View user with id");

	    $sql = "SELECT id,title FROM question WHERE userId = ?;";
	    $askedQuestions = $this->db->executeFetchAll($sql,array($id));

	    $sql = "SELECT question.id,question.title FROM question LEFT OUTER JOIN answer ON answer.questionId = question.id WHERE answer.userId = ?;";
	    $answeredQuestions = $this->db->executeFetchAll($sql,array($id));

	    $this->views->add('users/view', [
	        'user' => $user,
	        'title' => $user->acronym,
	        'askedQuestions' => $askedQuestions,
	        'answeredQuestions' => $answeredQuestions
	    ]);
	}

	public function addAction($acronym = null, $name = null, $mail = null, $password = null)
	{
	    if (!isset($acronym)) {
	        die("Missing acronym");
	    }
	 
	    $now = date('y-m-d H:i:s');
	 
	    $this->users->save([
	        'acronym' => $acronym,
	        'name' => $name,
	        'email' => $mail,
	        'password' => password_hash($password, PASSWORD_DEFAULT),
	        'created' => $now,
	        'active' => $now,
	    ]);
	 
	    $url = $this->url->create('users/id/' . $this->users->id);
	    $this->response->redirect($url);
	}

	public function deleteAction($acronym = null, $password = null)
	{
		$id = null;

	    if (!isset($acronym)) {
	        die("Missing acronym");
	    }
	 	
	 	$all = $this->users->findAll();
	 	foreach($all as $user){
	 		if($user->acronym == $acronym && $user->password = password_hash($password, PASSWORD_DEFAULT)){
	 			$id = $user->id;
	 		}
	 	}

	 	if(!isset($id)){
	 		die("No such user were found");
	 	}

	    $res = $this->users->delete($id);
	 
	    $url = $this->url->create('users/list');
	    $this->response->redirect($url);
	}

	public function softDeleteAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 
	    $now = date('y-m-d H:i:s');
	 
	    $user = $this->users->find($id);
	 
	    $user->deleted = $now;

	    $user->save();
	 
	    $url = $this->url->create('users/trashBin');
	    $this->response->redirect($url);
	}

	public function deactivateAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }
	 
	    $user = $this->users->find($id);

	    $user->active = NULL;

	    $user->save();
	 
	    $url = $this->url->create('users/id/'.$user->id);
	    $this->response->redirect($url);
	}

	public function restoreAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }

	    $user = $this->users->find($id);

	    $user->deleted = NULL;

	    $user->save();
	 
	    $url = $this->url->create('users/all');
	    $this->response->redirect($url);
	}

	public function activateAction($id = null)
	{
	    if (!isset($id)) {
	        die("Missing id");
	    }

	    $now = date('y-m-d H:i:s');

	    $user = $this->users->find($id);

	    $user->active = $now;

	    $user->save();
	 
	    $url = $this->url->create('users/id/'.$user->id);
	    $this->response->redirect($url);
	}

	public function activeAction()
	{
	    $all = $this->users->query()
	        ->where('active IS NOT NULL')
	        ->andWhere('deleted IS NULL')
	        ->execute();
	 
	    $this->theme->setTitle("Users that are active");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Users",
	    ]);
	}

	public function inactiveAction()
	{
	    $all = $this->users->query()
	        ->where('active is NULL')
	        ->andWhere('deleted IS NULL')
	        ->execute();
	 
	    $this->theme->setTitle("Users that are inactive");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Users that are inactive",
	    ]);
	}

	public function trashBinAction()
	{
	    $all = $this->users->query()
	        ->where('deleted IS NOT NULL')
	        ->execute();
	 
	    $this->theme->setTitle("Users that are inactive");
	    $this->views->add('users/list-all', [
	        'users' => $all,
	        'title' => "Users that are active",
	    ]);
	}

	public function editAction($id = null){
		$user = $this->users->find($id);

		$this->dispatcher->forward(['controller' => 'form-edit-user', 'action' => 'index','params' => array($user)]);
	}

}