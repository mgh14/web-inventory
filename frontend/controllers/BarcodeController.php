<?php
namespace frontend\controllers;

use frontend\models\db\record\Barcode;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;

class BarcodeController extends Controller {


    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],   // allow access to all functions if logged in
                    ],
                    /*[
                        'action' => ['AdministerItemRequest'],
                        'allow' => true,
                        'roles' =>
                    ]*/
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionScanItems() {
        return $this->render("scan-items");
    }

    public function actionAddBarcode() {
        $barcodeNum = \Yii::$app->request->getQueryParam("barcodeNum");
        if (empty($barcodeNum) || strlen($barcodeNum) != Barcode::UPC_A_BARCODE_LENGTH) {
            throw new BadRequestHttpException("Malformed barcode parameter");
        }

        $barcode = new Barcode();
        $barcode->number = $barcodeNum;
        return ($barcode->save(true, ["number"])) ? "success" : "failure";
    }

}