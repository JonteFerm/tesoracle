<?php
require __DIR__.'/config_with_app.php'; 
$app->theme->configure(ANAX_APP_PATH .'config/theme-grid.php');
$app->navbar->configure(ANAX_APP_PATH. 'config/navbar_theme.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


$app->router->add('', function() use ($app){
	$app->theme->setTitle("Tema");
	$app->views->addString('<h1>Tjena!</h1><p>Detta är ett tema!</p>', 'main');
});

$app->router->add('grid', function() use ($app){
	$app->theme->addStylesheet('css/anax-grid/grid_demo.css');
	$app->theme->setTitle("Rutnät");
	$app->views->addString('<h1>Tjena!</h1><p>Detta är ett tema!</p>', 'main');

});


$app->router->add('regioner', function() use ($app){
	$app->theme->addStylesheet('css/anax-grid/grid_demo.css');
	$app->theme->addStylesheet('css/anax-grid/regions_demo.css');
	$app->theme->setTitle("Regioner");
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
});



$app->router->add('typography', function() use ($app){
	$app->theme->addStylesheet('css/anax-grid/grid_demo.css');
	$app->theme->setTitle("Typografi");
    $content = $app->fileContent->get('typography.html');

    $app->views->addString($content, 'main')
               ->addString($content, 'sidebar');


});

$app->router->add('fontawsome', function() use ($app){
	$app->theme->setTitle("Font Awsome");
	$app->views->addString("<p><i class='fa fa-camera-retro fa-3x'></i> fa-camera-retro</p>", "main")
				->addString("<p><i class='fa fa-binoculars fa-2x'></i> fa-binoculars</p>","main");	

});

$app->router->handle();
$app->theme->render();
