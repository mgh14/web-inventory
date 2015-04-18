<?php
namespace frontend\views\collection;
use frontend\assets\CollectionsAsset;
use frontend\assets\InputDriverTemplateAsset;
use frontend\views\LayoutHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var Array $collections
 */


$this->title = "Measurement Requirements";

CollectionsAsset::register($this, View::POS_BEGIN);
InputDriverTemplateAsset::register($this, View::POS_BEGIN);

//echo $deleteDialog;

ob_start();
?>

    <input id="searchBar" class="typeahead form-control"
           type="text" placeholder="Enter a search value">

<?php
$inputHtml = ob_get_clean();

echo LayoutHelper::buildFromInputDriverTemplate("collectionSearchFormGroup",
    "Collection Search", $inputHtml, "", "Get Collections");

?>
<div class="collectionAccordion">

<?php

$count = 1;
foreach ($collections as $collection) {
    if ($count++ == 10) {
        break;
    }
    ?>

    <h3>
        <?php echo ucfirst($collection->name)?>
    </h3>
    <div>
        <ul>
            <li>Item 1</li>
            <li>Item 2</li>
            <li>Item 3</li>
        </ul>

        <div><a href=""><i>See All</i></a></div>
    </div>
<?php
}
?>

</div>
