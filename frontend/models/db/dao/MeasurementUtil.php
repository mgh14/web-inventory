<?php
namespace frontend\models\db\dao;

use frontend\models\db\record\Measurement;

class MeasurementUtil {

    private static $MEASUREMENT_TYPES = ["boolean", "float", "letter", "custom"];
    private static $BOOLEAN_VALUES = ["true", "false"];
    private static $LETTER_VALUES = ["xs", "s", "m", "l", "xl", "xxl", "3xl", "4xl"];
    // note that 'float' values must be floating point values,
    // and that 'custom' values can be any non-empty string
    private static $VALUE_TYPE_DISPLAY_NAMES = ["boolean" => "True/False",
        "float" => "Number", "letter" => "Letter Size", "custom" => "Custom"];

    public function validateMeasurement($measurementName, $measurementType) {
        return !empty($measurementName) && $this->isValidValueType($measurementType);
    }

    public function isValidValueType($valueType) {
        return in_array($valueType, static::$MEASUREMENT_TYPES);
    }

    /*public static function getAllRequirementTypesBySport($sportId) {
        $command = static::getDb()->createCommand("SELECT * FROM" . " " . static::tableName() .
            " WHERE sport_id = :sportId");
        return $command->bindValue(":sportId", $sportId)->queryAll();
    }*/

    public function getMeasurementsByName($name) {
        $db = \Yii::$app->db;
        $command = $db->createCommand("SELECT name FROM" . " " .
            Measurement::tableName() . " WHERE LOWER(name) LIKE :name LIMIT 5;");
        return $command->bindValue(":name", "%" . $name . "%")->queryAll();
    }

    public function getMeasurementsBySport($sportId) {
        $db = \Yii::$app->db;
        $command = $db->createCommand("SELECT measurement_id, name, value_type FROM" . " " .
            MeasurementCollectionDao::tableName() . " src INNER JOIN " .
            Measurement::tableName() . " sr ON (src.measurement_id = sr.id) " .
            " WHERE sport_id = :sportId");
        return $command->bindValue(":sportId", $sportId)->queryAll();
    }

    public function getHtmlForMeasurement($measurementId, $measurementName, $valueType) {
        ob_start();
        ?>
        <div class="measurement">
            <div class="displayMeasurement">
                <div class="opacityLink measurementName"><?php echo trim(ucfirst($measurementName))?></div>
                <div class="measurementType"><?php echo static::$VALUE_TYPE_DISPLAY_NAMES[$valueType]?></div>
            </div>
            <div class="editMeasurement">
                <div class="measurementNameInputContainer">
                    <div>Measurement Name:</div>
                    <input type="text" class="measurementNameInput"
                           value="<?php echo trim($measurementName)?>" />
                </div>
                <div class="spacer"></div>
                <div class="measurementTypeSelectContainer">
                    <div>Type:</div>
                    <?php echo $this->getDropdownOfPossibleValueTypes(
                        static::$VALUE_TYPE_DISPLAY_NAMES[$valueType],
                        "measurementTypeSelect")?>
                </div>

                <div class="editMeasurementBtns">
                    <button class="btn saveMeasurement">Save</button>
                    <button class="btn deleteMeasurement">Delete</button>
                    <button class="btn cancelEdit">Cancel</button>
                </div>
            </div>

            <div class="hidden originalMeasurementId"><?php echo trim($measurementId)?></div>
            <div class="hidden originalMeasurementName"><?php echo trim($measurementName)?></div>
            <div class="hidden originalMeasurementType"><?php echo $valueType?></div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function getDeleteDialogBox($containerClasses, $nameClasses) {
        ob_start();
        ?>

        <div id="<?php echo trim($containerClasses)?>" title="Delete?">
            <p><span class="ui-icon ui-icon-alert"
                     style="float:left; margin:0 7px 20px 0;"></span>
                Are you sure you want to delete measurement &apos;
                <span class="<?php echo trim($nameClasses)?>"></span>&apos;?
            </p>
        </div>

        <?php
        return ob_get_clean();
    }

    public function getHtmlForMeasurementsBySport($sportId) {
        $measurementReqs = $this->getMeasurementsBySport($sportId);
        if (!$measurementReqs) {
            return "<div><i>No required measurements entered for this sport.</i></div>";
        }

        ob_start();
        foreach ($measurementReqs as $measurementReq) {
            echo $this->getHtmlForMeasurement($measurementReq['measurement_id'],
                $measurementReq['name'], $measurementReq['value_type']);
        }
        ?>

        <div class="editInstructions" style="margin-top: 20px;">
            <i>Click on a measurement name to edit the measurement&apos;s title or type</i>
        </div>

        <?php
        return ob_get_clean();
    }

    /*public function getHtmlForSizeRequirementsBySport($sportId) {
        $sizeReqs = $this->getSizeRequirementsBySport($sportId);
        $html = "";
        foreach ($sizeReqs as $sizeReq) {
            $name = $sizeReq['name'];
            switch(strtolower($sizeReq['value_type'])) {
                case "boolean":
                    $html .= $this->generateBooleanHtml($name, $sizeReq['name'] . "aaa");
                    break;
                case "float":
                    $html .= $this->generateFloatHtml($name);
                    break;
                case "letter":
                    $html .= $this->generateLetterHtml($name);
                    break;
                case "custom":
                    $html .= $this->generateCustomHtml($name);
                    break;
            }
        }

        return $html;
    }*/

    public function getDropdownOfPossibleValueTypes($selectedValue, $htmlClasses) {
        ob_start();
        ?>

        <select class="<?php echo $htmlClasses?>">

        <?php
        foreach (static::$VALUE_TYPE_DISPLAY_NAMES as $key => $value) {
            $selected = ($value == $selectedValue) ? " selected='selected' " : "";
            ?>

            <option value="<?php echo $key?>" <?php echo $selected?>><?php echo $value?></option>

        <?php
        }
        ?>

        </select>

        <?php
        return ob_get_clean();
    }

    public function generateBooleanHtml($requirementName, $radioGroup) {
        $true = static::$BOOLEAN_VALUES[0];
        $false = static::$BOOLEAN_VALUES[1];
        ob_start();
        ?>

        <div>
            <div><?php echo $requirementName?>:</div>
            <input type="radio" name="<?php echo $radioGroup?>"
                   value="<?php echo $true?>"/> <?php echo $true?>
            <input type="radio" name="<?php echo $radioGroup?>"
                   value="<?php echo $false?>" /> <?php echo $false?>
        </div>

        <?php
        return ob_get_clean();
    }

    public function generateFloatHtml($name) {
        ob_start();
        ?>

        <div class="floatMeasurement">
            <div class=""><?php echo $name?></div>
            <input type="text"/>
        </div>

        <?php
        return ob_get_clean();
    }

    public function generateLetterHtml($name) {
        ob_start();
        ?>

        <div class="letterMeasurement">
            <div><?php echo $name?></div>
            <select>
                <?php
                foreach (static::$LETTER_VALUES as $value) {
                    ?>

                    <option value="<?php echo $value?>"><?php echo strtoupper($value)?></option>

                    <?php
                }
                ?>
            </select>
        </div>

        <?php
        return ob_get_clean();
    }

    public function generateCustomHtml($name) {
        ob_start();
        ?>

        <div>
            <div><?php echo $name?></div>
        </div>

        <?php
        return ob_get_clean();
    }

    private function validateMeasurementType($measurementType) {
        return in_array(strtolower($measurementType), static::$MEASUREMENT_TYPES);
    }

    private function validateBooleanMeasurementType($booleanValue) {
        return in_array(strtolower($booleanValue), static::$BOOLEAN_VALUES);
    }

    private function validateFloatMeasurementType($floatValue) {
        return is_float($floatValue);
    }

    private function validateLetterMeasurementType($letterValue) {
        return in_array(strtolower($letterValue), static::$LETTER_VALUES);
    }

    private function validateCustomMeasurementType($customValue) {
        return !empty($customValue);
    }

}