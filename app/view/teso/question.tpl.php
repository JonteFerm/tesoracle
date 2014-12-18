<article class='article1'>
<span class='outputSpan'><?=$output?></span>
<h2><?=$question->title?></h2>
<p>Posted: <?=$question->posted?></p>
<div class='question'>
	<figure>
		<img src="<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $question->email ) ) ) . "?s=" . 100;?>"/>
	</figure>
	<p><a href='<?=$this->url->create('users/id/'.$question->userId)?>'><?=$question->user?>:</a></p>
	<?=$question->text?>
	<?php foreach($comments as $comment): ?>
		<?php if($comment->questionId == $question->id): ?>
			<div class='commentDiv'>
				<p><a href='<?=$this->url->create('users/id/'.$comment->userId)?>'><?=$comment->user?>:</a> <?=$comment->text?></p>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php if(isset($user)):?>
	<form class='right' method='post'>
		<input type='hidden' name='userId' value='<?=$user->id?>' />
		<input type='hidden' name='questionId' value='<?=$question->id?>'/>
		<p><label>Comment: <textarea name='commentText'></textarea></label></p>
		<input class='right' type='submit' name='doComment' value='Submit'/>
	</form>
	<?php endif; ?>
</div>
<?php foreach(explode(',', $question->tag) as $tag): 

	$sql = "SELECT id FROM tags WHERE name = ?;";
	$res = $this->db->executeFetchAll($sql,array($tag));
	$tagId = $res[0]->id;
?>
<a class='tagSpan' style='text-decoration:none;' href='<?=$this->url->create('questions/viewTag/'.$tagId)?>'><span ><?=$tag?></span></a>
<?php endforeach; ?>
<?php if(isset($user)):?>
<h3>Write an answer:</h3>
<div class='writeAnswerDiv'>
	<form method='post'>
		<fieldset>
			<input type='hidden' name='questionId' value='<?=$question->id?>'/>
			<input type='hidden' name='userId' value='<?=$user->id?>' />
			<p><textarea name='answerInput'></textarea></p>
			<p><input type='submit' name='doAnswer' value='Post'/></p>
		</fieldset>
	</form>
</div>
<?php endif; ?>
<h3>Answers:</h3>
<?php foreach($answers as $answer): ?>
<div class='answersDiv'>
	<p class='right smallerText'>Posted: <?=$answer->posted?></p>
	<figure class='left'>
		<img src="<?="http://www.gravatar.com/avatar/" . md5( strtolower( trim( $answer->email ) ) ) . "?s=" . 100;?>"/>
	</figure>
	<p><a href='<?=$this->url->create('users/id/'.$answer->userId)?>'><?=$answer->user?>:</a></p>
	<?=$answer->text?>
	<?php foreach($comments as $comment): ?>
		<?php if($comment->answerId == $answer->id): ?>
			<div class='commentDiv'>
				<p class='right smallerText'><?=$comment->posted?></p>
				<p><a href='<?=$this->url->create('users/id/'.$comment->userId)?>'><?=$comment->user?>:</a> <?=$comment->text?></p>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php if(isset($user)):?>
	<form class='right' method='post'>
			<input type='hidden' name='userId' value='<?=$user->id?>' />
			<input type='hidden' name='answerId' value='<?=$answer->id?>'/>
			<p><label>Comment: <textarea name='commentText'></textarea></label></p>
			<input class='right' type='submit' name='doComment' value='Submit'/>
	</form>
	<?php endif; ?>
</div>
<?php endforeach; ?>
</article>