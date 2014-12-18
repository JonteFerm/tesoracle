<aside class="aside1 right">
<h1>Popular Tags</h1>
<?php foreach($popularTags as $tag): ?>
<a class='tagSpan' style='text-decoration:none;' href='<?=$this->url->create('questions/viewTag/'.$tag->id)?>'><span><?=$tag->name?></span></a>
<?php endforeach; ?>
</aside>

<article class="article1">
<h1>Latest Questions</h1>
<?php foreach($latestQuestions as $question): ?>
<div class='question'>
<p class='smallerText right'>Posted: <?=$question->posted?></p>
<p class='smallerText'>Answers: <?=$question->answers?></p>
<figure>
	<img src="<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $question->email ) ) ) . "?s=" . 100;?>"/>
</figure>
<p><a id='question-title' href='<?=$this->url->create('questions/id/'.$question->id)?>'><?=$question->title?></a></p>
<?php foreach(explode(',', $question->tag) as $tag): 
	$sql = "SELECT id FROM tags WHERE name = ?;";
	$res = $this->db->executeFetchAll($sql,array($tag));
	$tagId = $res[0]->id;
?>
<a class='tagSpan' style='text-decoration:none;' href='<?=$this->url->create('questions/viewTag/'.$tagId)?>'><span ><?=$tag?></span></a>
<?php endforeach; ?>
<p class='right'><a id='user-name' href='<?=$this->url->create('users/id/'.$question->userId)?>'><?=$question->user?></a></p>
</div>
<?php endforeach; ?>
</article>

<article class="article1">
<h1>Most Active Users</h1>
<?php foreach($frequentUsers as $user): ?>
<a href='<?=$this->url->create('users/id/'.$user->id)?>' class='userLink'>
<img class='left' src='<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?s=" . 50;?>'>
<p><?=$user->acronym?></p>
</a>
<?php endforeach; ?>

</article>
