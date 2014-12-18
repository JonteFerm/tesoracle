<?php
require __DIR__.'/config_with_app.php'; 
$app->theme->configure(ANAX_APP_PATH .'config/theme-ferm.php');
$app->navbar->configure(ANAX_APP_PATH. 'config/navbar_theme.php');
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);


$app->router->add('', function() use ($app){
	$app->theme->setTitle("Tema");
  $app->theme->addStylesheet('css/anax-ferm/colours.css');
  $content = $app->fileContent->get('lorem_ipsum_1.md');
  $app->views->addString('<h1>Välkommen till mitt tema!</h1><p> Här på förstasidan ser du temat in action. Om du vill se detaljer för temat väljer du ett alternativ
    i menyn till vänster.</p><h2>Nu...</h2><p>Kommer lite nonsenstext så att du kan se hur temat ser ut när det är fyllt med text.</p>', 'main')
          ->addString($content, 'main')
          ->addString('<h2>Här kan man t.ex. ha länkar!</h2><ul><li>Länk<li>Länk<li>Länk</ul>', 'sidebar');
  $app->views->addString('<h3>Här ser du ett exempel på användning av temat!</h3>
    <p>Du kan i menyn välja vad du vill se.</p>
    <p>Detta tema är responsivt och fungerar mycket fint på mindre skärmar!</p>
    ', 'flash')
       ->addString('<h4>Här kan man ha t.ex. reklam.</h4>', 'featured')
       ->addString("<p><i class='fa fa-beer fa-3x'></i> &nbsp;&nbsp;<i class='fa fa-thumbs-up fa-3x'></i> &nbsp;&nbsp;<i class='fa fa-angellist fa-3x'></i>
         &nbsp;&nbsp;<i class='fa fa-bitcoin fa-3x'></i> &nbsp;&nbsp;<i class='fa fa-bomb fa-3x'></i></p>", "featured")
       ->addString('<p>Här kan man ha mycket kul!</p>', 'footer-col-1')
       ->addString('<p>Det kan man ha här med!</p>', 'footer-col-2')
       ->addString('<p>...och även i denna ruta.</p>', 'footer-col-3');
});

$app->router->add('grid', function() use ($app){
	$app->theme->addStylesheet('css/anax-ferm/grid_demo.css');
  $app->theme->addStylesheet('css/anax-ferm/regions_demo.css');
	$app->theme->setTitle("Rutnät");

      $app->views->addString('flash', 'flash')
               ->addString('featured', 'featured')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych', 'triptych')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3');

});


$app->router->add('regioner', function() use ($app){
	$app->theme->addStylesheet('css/anax-ferm/regions_demo.css');
	$app->theme->setTitle("Regioner");

    $app->views->addString('flash', 'flash')
               ->addString('featured', 'featured')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych', 'triptych')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3');
});



$app->router->add('typography', function() use ($app){
	$app->theme->addStylesheet('css/anax-ferm/grid_demo.css');
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