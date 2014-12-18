<article class='article1'>
<h1>Questions</h1>
<?php if(isset($user)): ?>
<p><a style='text-decoration:none;' href='?ask'><span class='askButton'>ASK A QUESTION</span></a></p>
<?php if(isset($_GET['ask'])): ?>
<span class='outputSpan'><?=$output?></span>
<form class='askForm' method='post'>
	<fieldset>
		<input type='hidden' name='userId' value='<?=$user->id?>'/>
		<label>Title: <p><input type='text' name='questionTitle' /></p></label>
		<label>Text: <p><textarea name='questionText'></textarea></p></label>
		<label>Tags: <p><select name='questionTags[]' multiple='multiple' ><?=$tags?></select></label>
		<p><input type='submit' name='doAsk' value='Ask'/></p>
	</fieldset>
</form>
<?php endif; ?>
<?php endif; ?>
<h2><?=$subTitle?></h2>
<?php foreach ($questions as $question) : ?>
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