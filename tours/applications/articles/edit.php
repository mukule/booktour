
<div class="col-md-12 form">
<?php

if(isset($_POST['submitThis']) && $_POST['submitThis'] == "Submit")
	{
	if(empty($_POST['title']) || empty($_POST['description']) || empty($_POST['article_position_id']) )
		echo '<div class="col-md-12 isa_warning text-center">Enter all details needed</div>';
	else
		echo articlesModel::submitArticle($_POST);

	}
	
	if(isset($itemId) && $itemId > 0)
		$article = articlesModel::articleDetails($itemId);
	
	$title = isset($_POST['title']) ? $_POST['title'] : ( isset($article->title) ? $article->title  : '' );
	$description = isset($_POST['description']) ? $_POST['description'] : ( isset($article->description) ? $article->description  : '' );

	?>
	
<form action="" method="post" class="form">
    <div class="col-md-12">
        <label class="required">Title : </label>
        <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" required />
    </div>
     
    <div class="col-md-12">
        <label class="required">Article position : </label>
        <select name="article_position_id" class="form-control" required>
        	<option value="">--select article position--</option>
            <?php
			$positions =  articlePositionsModel::listPositions();
			
			foreach($positions as $position )
				{
				$sel = isset($_POST['article_position_id']) && $_POST['article_position_id'] == $position->id ? 'selected="selected"' : ( isset($article->article_position_id) && $article->article_position_id == $position->id ? 'selected="selected"'  : '' );
				echo '<option value="'.$position->id.'" '.$sel.'>'.$position->position.'</option>';
				}
			?>
        </select>
        
    </div>    
    
    <div class="col-md-12">
        <label class="required">Description : </label>
        <textarea class="mceEditor" name="description" ><?php echo $description; ?></textarea>
    </div>

    <div class="col-md-12 text-center">
        <input type="submit" class="btn" name="submitThis" value="Submit" />
        
        <?php
        if(isset($itemId) && $itemId > 0 )	//superadmins              
            echo '<a href="'.$urls.'&pg=details&itemId='.$itemId.'" class="btn">Cancel</a>';
        else
            echo '<a href="'.$urls.'" class="btn">Cancel</a>';
        ?>
    </div>        
    
    <?php if(isset($itemId) && $itemId > 0): ?>
        <input type="hidden" name="articleid" value="<?php echo $itemId; ?>" />
    <?php endif; ?>
    
    <input type="hidden" name="url" value="<?php echo $urls; ?>" />
    
</form>

	
</div>