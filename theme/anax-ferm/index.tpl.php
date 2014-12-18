<!doctype html>
<html class='no-js' lang='<?=$lang?>'>
<head>
<meta charset='utf-8'/>
<title><?=$title . $title_append?></title>
<?php if(isset($favicon)): ?><link rel='icon' href='<?=$this->url->asset($favicon)?>'/><?php endif; ?>
<?php foreach($stylesheets as $stylesheet): ?>
<link rel='stylesheet' type='text/css' href='<?=$this->url->asset($stylesheet)?>'/>
<?php endforeach; ?>
<?php if(isset($style)): ?><style><?=$style?></style><?php endif; ?>
<script src='<?=$this->url->asset($modernizr)?>'></script>
</head>

<body>

<div id='wrapper'>

	<div id='header'>
	<?php if(isset($header)) echo $header?>
	<?php $this->views->render('header')?>
	</div>

	<?php if ($this->views->hasContent('navbar')) : ?>
	<div id='navbar'>
	<?php $this->views->render('navbar')?>
	</div>
	<?php endif; ?>

	<?php if($this->views->hasContent('flash')) : ?>
	<div id='flash'><?php $this->views->render('flash')?></div>
	<?php endif; ?>

	<?php if($this->views->hasContent('featured')) : ?>
	<div id='featured'><?php $this->views->render('featured')?></div>
	<?php endif; ?>

	<div id='wrap-triptych'>

	<div id='main'>
	<?php if(isset($main)) echo $main?>
	<?php $this->views->render('main')?>
	</div>

	<?php if($this->views->hasContent('sidebar')) : ?>
	<div id='sidebar'><?php $this->views->render('sidebar')?></div>
	<?php endif; ?>
	</div>
	

	<?php if ($this->views->hasContent('footer-col-1', 'footer-col-2', 'footer-col-3')) : ?>
	<div id='wrap-triptych'>
	    <div id='footer-col-1'><?php $this->views->render('footer-col-1')?></div>
	    <div id='footer-col-2'><?php $this->views->render('footer-col-2')?></div>
	    <div id='footer-col-3'><?php $this->views->render('footer-col-3')?></div>
	</div>
	<?php endif; ?>

	<div id='footer'>
	<?php if(isset($footer)) echo $footer?>
	<?php $this->views->render('footer')?>
	</div>


</div>

<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>

<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$this->url->asset($val)?>'></script>
<?php endforeach; endif; ?>

<?php if(isset($google_analytics)): ?>
<script>
  var _gaq=[['_setAccount','<?=$google_analytics?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>

</body>
</html>
