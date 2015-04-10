<?php
namespace frontend\models\db\record;

use Yii;
use yii\db\ActiveRecord;

class Barcode extends ActiveRecord {

    const UPC_A_BARCODE_LENGTH = 12;

    public static function tableName() {
        return "barcode";
    }

    public function rules() {
        return [
            ['number', 'validateBarcodeInput'],
        ];
    }

    public function validateBarcodeInput($attribute, $params) {
        // no real check at the moment to be sure that the error is triggered
        if (!static::isValidUpcaBarcode($this[$attribute])) {
            $this->addError($attribute, 'You entered an invalid barcode.');
        }

        return; // no validation errors
    }

    /* @var $barcode String */
    public static function isValidUpcaBarcode($barcode) {
        if (empty($barcode) || strlen($barcode) != static::UPC_A_BARCODE_LENGTH ||
            !is_numeric($barcode)) {
            return false;
        }

        $oddDigitsSum = 0;
        $evenDigitsSum = 0;
        for($i=0; $i<(static::UPC_A_BARCODE_LENGTH - 1); $i++) {
            if (!is_numeric($digit = $barcode[$i]) || $digit < 0) {
                return false;   // invalid digit present in the string
            }

            if ($i % 2 == 0) {
                $oddDigitsSum += $digit;
            }
            else {
                $evenDigitsSum += $digit;
            }
        }

        // calculate expected digit (stored in $remainder)
        $totalSum = ($oddDigitsSum * 3) + $evenDigitsSum;
        $remainder = 10 - ($totalSum % 10);
        if ($remainder == 10) {
            $remainder = 0;
        }

        $lastDigit = $barcode[static::UPC_A_BARCODE_LENGTH - 1];
        return (is_numeric($lastDigit) && $remainder == intval($lastDigit));
    }

}