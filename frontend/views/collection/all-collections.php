<?php
namespace frontend\views\collection;

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

<h1>Countries</h1>
<ul>
<?php
    $count = 1;
    foreach ($collections as $collection) {
    ?>
        <li>
            <?php echo Html::encode($count++ . ") " . "$collection->name"); ?>
        </li>
    <?php
    }
    ?>
</ul>

<?php echo LinkPager::widget(['pagination' => $pagination]) ?>