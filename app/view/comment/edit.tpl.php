<article class='article1'>
<div class='comment-form'>
    <form method=post>
        <fieldset>
        <input type='hidden' name="redirect" value="<?=$this->url->create($redirect)?>">
        <input type='hidden' name="identifier" value="<?=$identifier?>">
        <legend>Edit a comment</legend>
        <input type='hidden' name='id' value='<?=$comment->id?>'/>
        <p><label>Comment:<br/><textarea name='content'><?=$comment->content?></textarea></label></p>
        <p><label>Name:<br/><input type='text' name='name' value='<?=$comment->name?>'/></label></p>
        <p><label>Homepage:<br/><input type='text' name='web' value='<?=$comment->homepage?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$comment->email?>'/></label></p>
        <p><label>Image:<br/><input type='text' name='image' value='<?=$comment->image?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doSave' value='Save' onClick="this.form.action = '<?=$this->url->create('comment/save')?>'"/>
            <input type='reset' value='Reset'/>
        </p>
        <!--<output><?=$output?></output>-->
        </fieldset>
    </form>
</div>
<article>