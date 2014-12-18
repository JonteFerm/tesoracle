<article class='article1'>
<h1>Gästbok</h1>
<?php foreach ($comments as $comment) : ?>
<div class='commentsMe'>
<div class='tool right' ><a href="<?=$this->url->create('comment/remove?removeId='.$comment->id)?>" >X</a></div>
<div class='tool'><a href="<?=$this->url->create('comment/edit?editId='.$comment->id)?>">Edit</a></div>
<figure><?php if(!empty($comment->image)): ?>
<img src="<?=$comment->image?>"/>
<?php else: ?>
<img src="img/anax.png"/>
<?php endif; ?>
<figcaption ><p><b><?=$comment->name?></b></p><p><?=$comment->email?></p>
<?php if(!empty($comment->homepage)) : ?>
<p><a href='<?=$comment->homepage?>'>Website</a></p></figcaption>
<?php endif; ?>
</figure>
<article style='width:85%; float:right; word-wrap: break-word;'><p><?=$comment->content?></p></article>
</div>
<?php endforeach; ?>
</article> 