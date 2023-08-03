<?php

$item = articlesModel::getArticle("safety");

?>
<h2 class="page-header"><?php echo $item->title; ?></h2>

<div class="col-md-12"><?php echo $item->description; ?></div>