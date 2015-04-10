<?php
use frontend\assets\InputDriverTemplateAsset;
use frontend\assets\SportMeasurementAsset;
use frontend\views\LayoutHelper;
use yii\web\View;

/**
 * @var $allCategories Array[Sport]
 * @var $valueTypesDropdown String (HTML)
 * @var $deleteDialog String (HTML)
 */

$this->title = "Measurement Requirements";

SportMeasurementAsset::register($this, View::POS_BEGIN);
InputDriverTemplateAsset::register($this, View::POS_BEGIN);

echo $deleteDialog;

ob_start();
?>
    <select id="sportCategory" class="form-control sportCategorySelect">
        <option value="0" selected="selected">Select a sport</option>
        <?php

        foreach ($allCategories as $category) {
            ?>

            <option value="<?php echo $category['id']?>"><?php echo $category['name']?></option>

            <?php
        }
        ?>
    </select>
<?php
$selectHtml = ob_get_clean();

echo LayoutHelper::buildFromInputDriverTemplate("sportCategory", "Sport Category", $selectHtml,
    "getMeasurements", "Get Measurements");
?>

<div>
    <div class="measurementsContainer"></div>
    <div class="horizontalRule"><hr/></div>

    <div class="addMeasurementContainer">
        <div class="addNewMeasurementContainer">
            <div><b>Add a new measurement:</b></div>

            <div class="addMeasurementValues newMeasurementValues">
                <div>
                    <div>Name:</div>
                    <input class="newMeasurementNameInput valuesContainer" type="textbox"
                           placeholder="Type a name"/>
                </div>
                <div class="spacer"></div>
                <div>
                    <div>Type of Measurement:</div>
                    <?php echo $valueTypesDropdown?>
                </div>
            </div>

            <button class="btn addMeasurementBtn addNewMeasurementBtn">Add Measurement</button>
        </div>

        <div class="orSpacer"><b><i>or</i></b></div>

        <div class="addExistingMeasurementContainer">
            <div><b>Add a new measurement:</b></div>

            <div class="addMeasurementValues existingMeasurementValues">
                <div>
                    <div>Name:</div>
                    <input class="typeahead existingMeasurementNameInput valuesContainer"
                           id="existingMeasurementNameInputId"
                           type="textbox" placeholder="Type a name"/>
                </div>
                <div class="spacer"></div>
                <a class="opacityLink" href="">See all measurements</a>
            </div>

            <button class="btn addMeasurementBtn addExistingMeasurementBtn">Add Measurement</button>
        </div>
    </div>

    <div style="clear: both"></div>
</div>
