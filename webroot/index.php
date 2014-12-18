<?php
require __DIR__.'/config_with_app.php';
$app->theme->configure(ANAX_APP_PATH . 'config/theme.php');
$app->navbar->configure(ANAX_APP_PATH. 'config/navbar.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);
$app = new \Anax\MVC\CApplicationBasic($di); //To enable session wrapping.

 $di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
    $db->connect();
    return $db;
});

$di->session();

$di->set('BlackgateOptions', function() use ($di) {
	$options = new \Jofe\Blackgate\COptions();
	$options->setDI($di);
	return $options;
});

/*
// ____________________________________________________
// Controllers
// ____________________________________________________
*/

$di->set('UsersController', function() use ($di) {
    $controller = new \Anax\Users\UsersController();
    $controller->setDI($di);
    return $controller;
});

$di->set('CommentController', function() use ($di) {
    $controller = new \Anax\Comments\CommentController();
    $controller->setDI($di);
    return $controller;
});

$di->set('QuestionsController', function() use($di){
	$controller = new \Teso\Questions\QuestionsController();
	$controller->setDI($di);
	return $controller;
});

/*
// ------------------
// Form controllers
// ------------------
*/
$di->set('FormAddCommentController', function() use ($di) {
    $controller = new \Anax\Comments\FormAddCommentController();
    $controller->setDI($di);
    return $controller;
});

$di->set('FormEditCommentController', function() use ($di) {
    $controller = new \Anax\Comments\FormEditCommentController();
    $controller->setDI($di);
    return $controller;
});


$di->set('FormSmallController', function() use ($di){
 	$controller = new \Anax\HTMLForm\FormController();
 	$controller->setDI($di);
 	return $controller;
 });

$di->set('FormAddUserController', function() use ($di){
 	$controller = new \Anax\Users\FormAddUserController();
 	$controller->setDI($di);
 	return $controller;
 });

$di->set('FormEditUserController', function() use ($di){
 	$controller = new \Anax\Users\FormEditUserController();
 	$controller->setDI($di);
 	return $controller;
 });

$di->set('FormDeleteUserController', function() use ($di){
 	$controller = new \Anax\Users\FormDeleteUserController();
 	$controller->setDI($di);
 	return $controller;
 });


/*
// ____________________________________________________
// Main routes
// ____________________________________________________
*/


$app->router->add('', function() use ($app){
	$app->theme->setTitle("Home");

	$sql = "SELECT * FROM vquestion ORDER BY posted DESC LIMIT 3;";
	$latestQuestions = $app->db->executeFetchAll($sql);

	$sql = "SELECT user.*, ((SELECT COUNT(Q.id) FROM question AS Q WHERE Q.userId = user.id)+ (SELECT COUNT(A.id) FROM answer AS A 
	WHERE A.userId = user.id)) AS activity FROM user ORDER BY activity DESC LIMIT 4;";
	$frequentUsers = $app->db->executeFetchAll($sql);

	$sql = "SELECT tags.*, (SELECT COUNT(q2t.tagId) FROM question2tag AS q2t WHERE q2t.tagId = tags.id) AS frequency
	FROM tags ORDER BY frequency DESC LIMIT 10;";
	$popularTags = $app->db->executeFetchAll($sql);

	$app->views->add("teso/start", [
		'latestQuestions' => $latestQuestions,
		'frequentUsers'	=> $frequentUsers,
		'popularTags'	=> $popularTags
	]);

});

$app->router->add('questions', function() use ($app){
	$app->theme->setTitle("Questions");


	$app->dispatcher->forward(['controller' => 'questions', 'action' => 'viewAll']);

});

$app->router->add('tags', function() use ($app){
	$app->theme->setTitle("Tags");

	$sql = "SELECT * FROM tags;";
	$tags = $app->db->executeFetchAll($sql);

	$app->views->add('teso/tags', [
		'tags' => $tags,
	]);

});



$app->router->add('source', function() use ($app){
	$app->theme->addStylesheet('css/source.css');
	$app->theme->setTitle("Källkod");

	$source = new \Mos\Source\CSource([
		'secure_dir' => '..',
		'base_dir' => '..',
		'add_ignore' => ['.htaccess'],
	]);

	$app->views->add('teso/source', [
		'content' => $source->View(),
	]);
});

$app->router->add('login', function() use ($app){
	$output = null;

	$app->theme->setTitle("Log in");

	$options = $app->BlackgateOptions;
	$auth = new \Jofe\Blackgate\CAuthenticator($options);

	if(isset($_POST['doSubmit'])){
		if(isset($_POST['id']) && isset($_POST['password'])){
			$access = $auth->apply($_POST['id'], $_POST['password']);
			$output = $auth->getOutput();

			if($access){
				$user = $auth->getUser();
				$app->session->set('user',$user);
				
			}
		}
	}

	$form ="
		<form method=post>
		    <fieldset>
		    <p><label>User ID:<br/><input type='text' name='id' /></label></p>
		    <p><label>Password:<br/><input type='password' name='password'/></label></p>
		    <p><input type='submit' name='doSubmit' value='Login' /></p>
		    <span class='outputSpan'>$output</span>
		    </fieldset>
		    </form>
	";

	$app->views->add("teso/page", [
		'title' => 'Log In',
		'content' => $form
	]);

});

$app->router->add('logout', function() use ($app){
	$app->theme->setTitle("Log out");
	$app->session->set('user',null);

	$message = "<p>You are logged out.</p>";

	$app->views->add("teso/page", [
		'title' => 'Log Out',
		'content' => $message
	]);

});

$app->router->add('about', function() use ($app){
	$app->theme->setTitle("About");
	$content = $app->fileContent->get('about_teso.md');
	$content = $app->textFilter->doFilter($content,'shortcode, markdown');
	$app->views->add("teso/page", [
		'title' => 'About',
		'content' => $content
	]);

});

/*
//_____________________________________________________
// Question routes
//_____________________________________________________
*/

$app->router->add('questions/id/:number', function() use ($app){
	$app->dispatcher->forward(['controller' => 'question', 'action' => 'id']);
});

$app->router->add('questions/viewTag/:number', function() use ($app){
	$app->dispatcher->forward(['controller' => 'question', 'action' => 'viewTag']);
});

/*
// ____________________________________________________
// User routes
// ____________________________________________________
*/

$app->router->add('users/active', function() use($app){
	$app->dispatcher->forward(['controller' => 'users', 'action' => 'active']);
});

$app->router->add('users/id/:number', function() use($app){
	$app->dispatcher->forward(['controller' => 'users', 'action' => 'id']);
});

$app->router->add('users/add', function() use($app){
	$app->theme->setTitle("Register user");
    $app->dispatcher->forward(['controller' => 'form-add-user', 'action' => 'index']);
});

$app->router->add('users/edit/:number', function() use($app){
	$app->theme->setTitle("Edit user");
    $this->dispatcher->forward(['controller' => 'users', 'action' => 'edit']);
});

$app->router->add('users/deactivate/:number', function() use($app){
	$app->theme->setTitle("Update user");
	$app->dispatcher->forward(['controller' => 'users', 'action' => 'deactivate']);
});


$app->router->handle();
$app->theme->render();