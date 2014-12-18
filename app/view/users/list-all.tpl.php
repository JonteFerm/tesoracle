<article class='article1'>
<h1><?=$title?></h1>
<?php if(empty($users)) :?>
<p>Det finns inga användare här!</p>
<?php else:?>
<?php foreach($users as $user): ?>
<a href='<?=$this->url->create('users/id/'.$user->id)?>' class='userLink'>
<img class='left' src='<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?s=" . 50;?>'>
<p><?=$user->acronym?></p>

</a>
<?php endforeach; ?>
<?php endif; ?>
</article>
