<?php
namespace frontend\views;

class LayoutHelper {

    public static function buildFromInputDriverTemplate($formGroupLabel, $title, $inputHtml, $btnClasses, $btnText) {
        ob_start();
        ?>

        <div class="inputDriverDiv">
            <div class="inputDriverDiv inputGroup" style="display: inline-block;">
                <fieldset>
                    <label for="<?php echo $formGroupLabel?>"><?php echo $title?></label>
                    <div id="<?php echo $formGroupLabel?>Container" class="">
                        <?php echo $inputHtml?>
                        <!--<input id="searchBar" class="typeahead" type="text" placeholder="Enter a search value">-->
                    </div>
                </fieldset>
            </div>

            <button class="btn inputDriverBtn <?php echo $btnClasses?>" style="display: inline-block;"><?php echo $btnText?></button>

            <?php echo static::getViewButtons()?>
        </div>

        <hr>

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

        <div id="<?php echo trim($containerClasses)?>" title="Delete?">
            <p>
                <span class="ui-icon ui-icon-alert"
                     style="float:left; margin:0 7px 20px 0;"></span>
                <?php echo $deleteMessage?>
            </p>
        </div>

        <?php
        return ob_get_clean();
    }

    public static function getDeleteDialogBox2($containerClasses, $deleteMessage) {
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