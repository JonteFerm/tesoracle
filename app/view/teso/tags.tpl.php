<article class='article1'>
<h1>Tags</h1>
<?php foreach($tags as $tag):?>
<a class='tagSpan' style='text-decoration:none;' href='<?=$this->url->create('questions/viewTag/'.$tag->id)?>'><span><?=$tag->name?></span></a>
<?php endforeach; ?>
</article>