
<?php
 if(ACCESS_LVL != 1)
 	{
	echo '<div class="col-md-12 isa_error text-center"><p>Sorry, you dont have rights for this page</p>
		 <p><a href="'.$urls.'">Back to List</a></p></div>';
	return;
	}
?>


<?php

$maxOrder =faqsModel::getHighestOrdering();
$nextOrdering = $maxOrder+1;

if(isset($itemId))
	{
	$item = baseModel::faqDetails($itemId);
	$pgtitle = 'Edit FAQ';
	}
else
	$pgtitle = 'Add FAQ';
?>


<div class="col-md-12 page-title"><?php echo $pgtitle; ?></div>

<?php
$quiz = isset($_POST['quiz']) && strlen(trim($_POST['quiz'])) > 0 ? $_POST['quiz'] : (isset($item->quiz) && strlen(trim($item->quiz)) > 0 ? $item->quiz : '') ;

$answer = isset($_POST['answer']) && strlen(trim($_POST['answer'])) > 0 ? $_POST['answer'] : (isset($item->answer) && strlen(trim($item->answer)) > 0 ? $item->answer : '') ;

?>


<?php
if(isset($_POST['submitThis']) && $_POST['submitThis'] =="Submit")
	if(!empty($_POST['quiz']) && !empty($_POST['answer']))
		echo faqsModel::submitFAQ($_POST);
	else
		echo '<div class="">All fields are required filled</div>';
else
	{

?>

<form action="" method="post" class="form">
	<div class="col-md-12">
		<div class="col-md-3"><label>Question : </label></div>
    	<div class="col-md-9"><input type="text" name="quiz" class="form-control" value="<?php echo $quiz; ?>" required placeholder="question"></div>
    </div>
    
	<div class="col-md-12">
		<div class="col-md-3"><label>Answer : </label></div>
    	<div class="col-md-9"><textarea name="answer" class="form-control" required placeholder="answer"><?php echo $answer; ?></textarea></div>
    </div>
    
        
	<div class="col-md-12 text-center"><input type="submit" name="submitThis" value="Submit" class="btn" /> <a href="<?php echo $urls;?>" class="btn">Cancel</a></div>
        
    <?php if(isset($itemId) && $itemId > 0): ?>
        <input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
    <?php else: ?>        
        <input type="hidden" name="ordering" value="<?php echo $nextOrdering; ?>" />
    <?php endif; ?>   
    
     
    
	<?php
	$url = isset($itemId) && $itemId > 0 ? $urls.'&do=details&itemId='.$itemId : $urls;
	?>
    <input type="hidden" name="url" value="<?php echo $url; ?>" />   
    
    
</form>

<?php
}
?>
