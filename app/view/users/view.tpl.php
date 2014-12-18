<article class='article1'>
<h1><?=$title?>
	<span class='editSpan'><?php if(!empty($this->di->session->get('user')) && $this->di->session->get('user')->id == $user->id): ?>
	(<a href='<?=$this->url->create('users/edit/'.$user->id)?>'>Edit</a> &nbsp;&nbsp;
	<a href='<?=$this->url->create('users/activate/'.$user->id) ?>'>Set active</a> &nbsp;&nbsp;<a href='<?=$this->url->create('users/deactivate/'.$user->id) ?>
	'>Set inactive</a>)
	</span>
	<?php endif;?>
</h1>


<div class='right userHistDiv'>
	<h3>Questions answered</h3>
	<ul>
		<?php foreach($answeredQuestions as $answeredQuestion):?>
		<li><a href='<?=$this->url->create('questions/id/'.$answeredQuestion->id)?>'><?=$answeredQuestion->title?></a>
		<?php endforeach; ?>
	</ul>
</div>
<div class='right userHistDiv'>
	<h3>Questions asked</h3>
	<ul>
		<?php foreach($askedQuestions as $askedQuestion):?>
		<li><a href='<?=$this->url->create('questions/id/'.$askedQuestion->id)?>'><?=$askedQuestion->title?></a>
		<?php endforeach; ?>
	</ul>
</div>
 <ul>
	<li><img src='<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?s=" . 100;?>'/>
	<li><b>User #<?=$user->id?></b>
	<li><b>Acronym:</b> <?=$user->acronym?>
	<li><b>Name:</b> <?=$user->name?>
	<li><b>Joined:</b> <?=$user->created?>
	<li><b>E-mail:</b> <?=$user->email?>
	<li><b>Updated:</b> <?=$user->updated?>
	<?php if(!empty($user->active)):?>
	<li>User is <b>active</b>
	<?php else: ?>
	<li>User is <b>inactive</b> and won't appear on the users list
	<?php endif; ?>
</ul>
</article>