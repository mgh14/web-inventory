<?php
use frontend\assets\SportsCategoriesAsset;
use frontend\views\LayoutHelper;
use yii\web\View;

/**
 * @var $listView String (HTML)
 */

$this->title = "Sport Categories";
//$this->params['breadcrumbs'][] = $this->title;

SportsCategoriesAsset::register($this, View::POS_BEGIN);

echo LayoutHelper::getViewButtons();
?>

<div style="clear: both;"></div>
<hr/>

<div class="description"><i>Click on a category's name to edit it</i></div>
<br/>

<div class="sportsCategories">
    <?php echo $listView?>
</div>

