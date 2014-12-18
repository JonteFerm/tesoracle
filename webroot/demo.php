<?php
require __DIR__.'/config_with_app.php';
$app = new \Anax\MVC\CApplicationBasic($di);
$app->theme->configure(ANAX_APP_PATH . 'config/blackgate_demo_theme.php');
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

$app->router->add('', function() use ($app){
	$options = $app->BlackgateOptions;

	//Set the REQUIRED options
	$options->setTableName('user');
	$options->setIdColName('acronym');
	$options->setPassColName('password');
	$options->setActColName('active');
	$options->setDelColName('deleted');

	//Instantiate the authenticator with the options
	$auth = new \Jofe\Blackgate\CAuthenticator($options);
	$app->theme->setTitle("Blackgate Demo");
	$output = null;
	$restoreOutput = null;

	if(isset($_POST['doSubmit'])){
		if(isset($_POST['id']) && isset($_POST['password'])){
			$auth->apply($_POST['id'], $_POST['password']);
			$output = $auth->getOutput();
		}
	}

	if(isset($_POST['doRestore'])){
		if(isset($_POST['restoreId'])){
			$restoreOutput = $auth->restoreUser($_POST['restoreId']);
		}
	}


	$form ="
		<form style='float:left; width:55%;'method=post>
		    <fieldset>
		    <legend>Login</legend>
		    <p><label>User ID:<br/><input type='text' name='id' /></label></p>
		    <p><label>Password:<br/><input type='password' name='password'/></label></p>
		    <p><input type='submit' name='doSubmit' value='Login' /></p>
		    $output
		    </fieldset>
		    </form>
		";
	
	$form2 ="
		<form style='float:right; width:40%;' method=post>
		    <fieldset>
		    <legend>Restore</legend>
		    <p><label>User ID:<br/><input type='text' name='restoreId' /></label></p>
		    <p><input type='submit' name='doRestore' value='Restore' /></p>
		    $restoreOutput
		    </fieldset>
		    </form>
		";

	$content = $form2.$form;
	$app->views->add("me/page", [
		'content' => $content
	]);


});

$app->router->handle();
$app->theme->render();