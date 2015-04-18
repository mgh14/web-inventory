<?php
namespace frontend\views;

class LayoutHelper {

    public static function buildFieldset($containerClasses, $formGroupLabel, $title,
                                         $inputHtml, $btnClasses, $btnText, $extraHtml) {
        ob_start();
        ?>

        <div class="<?php echo $formGroupLabel?>FormContainer <?php echo $containerClasses?>">
            <div class="fieldsetWrapper">
                <fieldset class="input-group form-group">
                    <label for="<?php echo $formGroupLabel?>">
                        <h3><?php echo $title?></h3>
                    </label>

                    <div id="<?php echo $formGroupLabel?>Container" class="formGroupContainer">
                        <?php echo $inputHtml?>

                        <button class="btn inputDriverBtn <?php echo $btnClasses?>">
                            <?php echo $btnText?>
                        </button>
                    </div>
                </fieldset>
            </div>

            <?php echo $extraHtml?>
        </div>

        <?php
        return ob_get_clean();
    }

    public static function buildFromInputDriverTemplate($formGroupLabel, $title, $inputHtml,
        $btnClasses, $btnText) {

        ob_start();
        echo static::buildFieldset("inputDriverDiv", $formGroupLabel, $title, $inputHtml,
            "inputDriverBtn " . $btnClasses, $btnText, static::getViewButtons());
        ?>

        <hr/>

        <?php
        return ob_get_clean();
    }

    public static function getViewButtons() {
        ob_start();
        ?>

        <fieldset class="floatRight" id="viewBtnFieldset">
            <label for="viewBtns" id="viewBtnBanner">Viewing Style </label>
            <button class="btn viewBtn" id="listViewBtn" disabled="disabled">List</button>
            <button class="btn viewBtn" id="gridViewBtn" disabled="disabled">Grid</button>
        </fieldset>

        <?php
        return ob_get_clean();
    }

    public static function getLoadingGif() {
        ob_start();
        ?>

        <div id='loader1' class="loader">
            <img src="http://localhost/public_html/mr-test-two/frontend/images/load/ajax-loader.gif"/>
        </div>

        <?php
        return ob_get_clean();
    }

    public static function getDeleteDialogBox($containerClasses, $deleteMessage) {
        ob_start();
        ?>

        <div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-dialog-buttons
            dialogBox <?php echo $containerClasses?>" tabindex="-1">
            <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix
                ui-draggable-handle">
                <span class="ui-dialog-title">Delete?</span>
                <button type="button" class="ui-dialog-titlebar-close"></button>
            </div>
            <div id="deleteMeasurementDialog" class="ui-dialog-content ui-widget-content">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
                    <?php echo $deleteMessage?>
                </p>
            </div>
            <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
                <div class="ui-dialog-buttonset">
                    <button type="button" class="btn deleteMeasurementBtn">Delete</button>
                    <button type="button" class="btn cancelDeleteBtn">Cancel</button>
                </div>
            </div>
            <div class="hidden dialogData"></div>
        </div>

        <?php
        return ob_get_clean();
    }

}