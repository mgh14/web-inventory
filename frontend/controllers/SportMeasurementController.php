<?php
namespace frontend\controllers;

use frontend\models\db\dao\MeasurementCollectionDao;
use frontend\models\db\dao\MeasurementUtil;
use frontend\models\db\record\Measurement;
use frontend\models\db\record\Sport;
use frontend\views\LayoutHelper;
use yii\base\ErrorException;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class SportMeasurementController extends \yii\base\Controller {

    /* @var MeasurementUtil $measurementsUtil */
    private $measurementsUtil;

    public function init() {
        $this->measurementsUtil = new MeasurementUtil();
    }

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

    public function actionMeasurementsBySport() {
        $allCategories = Sport::find()->all();

        // create message for the 'delete' dialog
        ob_start();
        ?>

        Are you sure you want to delete measurement
        &apos;<span class="deleteMeasurementName"></span>&apos;
        from this sport?

        <?php
        return $this->render("measurements", [
            "allCategories" => $allCategories,
            "valueTypesDropdown" => $this->measurementsUtil->
                getDropdownOfPossibleValueTypes("", "newMeasurementTypeSelect"),
            "deleteDialog" => LayoutHelper::getDeleteDialogBox(
                "deleteMeasurementDialog", trim(ob_get_clean()))
        ]);
    }

    public function measurementExists($measurementName, $measurementType) {
        if ($this->measurementsUtil->validateMeasurement(
                $measurementName, $measurementType)) {
            throw new InvalidParamException("Measurement params are invalid");
        }

        return (Measurement::findOne(['name' => $measurementName,
            'value_type' => strtolower($measurementType)]) != false);
    }

    public function actionAddExistingMeasurementToCollection() {
        $sportId = intval(\Yii::$app->request->post('sportId'));
        if ($sportId < 1) {
            throw new BadRequestHttpException("sportId is invalid");
        }
        $measurementName = \Yii::$app->request->post('measurementName');
        if (empty($measurementName)) {
            throw new BadRequestHttpException("measurementName is invalid");
        }

        $measurementsBySport = $this->measurementsUtil->getMeasurementsBySport($sportId);
        $ids = array();
        foreach($measurementsBySport as $measurement) {
            $ids[] = intval($measurement["measurement_id"]);
        }
        foreach ($measurementsBySport as $measurement) {
            $equalNames = (strtolower($measurement["name"]) == strtolower($measurementName));
            if ($equalNames && !in_array(intval($measurement["measurement_id"]), $ids)) {
                MeasurementCollectionDao::insert($sportId, $measurement["measurement_id"]);
                return $this->measurementsUtil->getHtmlForMeasurement($measurement["measurement_id"],
                    $measurementName, $measurement["value"]);
            }
            else if ($equalNames) {
                throw new ErrorException("This measurement already belongs to this sport");
            }
        }

        $measurement = Measurement::findOne(["name" => $measurementName]);
        if ($measurement) {
            MeasurementCollectionDao::insert($sportId, $measurement["id"]);
            return $this->measurementsUtil->getHtmlForMeasurement($measurement["id"],
                $measurementName, $measurement["value_type"]);
        }

        throw new ServerErrorHttpException("Supposedly existing measurement was not found: " .
            $measurementName);
    }

    public function actionAddOrChangeMeasurement() {
        $measurementName = \Yii::$app->request->post("measurementName");
        if (empty($measurementName)) {
            throw new BadRequestHttpException("Empty new measurement name is not allowed");
        }

        $measurementRecord = null;
        $measurementId = intval(\Yii::$app->request->post("measurementId"));
        $valueType = \Yii::$app->request->post("measurementType");
        $measurementRecord = (empty($measurementId) || $measurementId < 1) ?
            $measurementRecord = Measurement::findOne(['name' => $measurementName]) :
            $measurementRecord = Measurement::findOne($measurementId);
        if (!$measurementRecord) {
            $measurementRecord = new Measurement();
        }

        if (!$this->measurementsUtil->validateMeasurement($measurementName, $valueType)) {
            throw new BadRequestHttpException("Measurement params are not valid");
        }

        $sportId = intval(\Yii::$app->request->post("sportId"));

        $measurementRecord['name'] = $measurementName;
        $measurementRecord['value_type'] = $valueType;
        $updatedRows = $measurementRecord->save();
        if ($updatedRows == 1 && $sportId > 0) {
            \Yii::$app->response->format = Response::FORMAT_HTML;
            MeasurementCollectionDao::insert($sportId, $measurementRecord['id']);

            $getElementHtml = \Yii::$app->request->post("getElementHtml");
            return ($getElementHtml || $getElementHtml == "true") ?
                $this->measurementsUtil->getHtmlForMeasurement($measurementRecord['id'],
                    $measurementRecord['name'], $measurementRecord['value_type']) :
                "1";
        }
        else if ($updatedRows == 1) {
            // TODO: Logging Warn
        }
        else {
            throw new \RuntimeException("Database error: no rows created or updated");
        }
    }

    public function actionDeleteMeasurementFromSport() {
        $sportId = intval(\Yii::$app->request->post("sportId"));
        if ($sportId < 1) {
            throw new BadRequestHttpException("Sport ID is invalid");
        }
        $measurementId = intval(\Yii::$app->request->post("measurementId"));
        if ($measurementId < 1) {
            throw new BadRequestHttpException("Measurement ID is invalid");
        }

        MeasurementCollectionDao::delete($sportId, $measurementId);
    }

    public function actionGetSportMeasurements() {
        $sportId = intval(\Yii::$app->request->getQueryParam("sportId"));
        if (empty($sportId) || $sportId < 1) {
            throw new BadRequestHttpException("SportId is invalid");
        }

        \Yii::$app->response->format = Response::FORMAT_HTML;
        return $this->measurementsUtil->getHtmlForMeasurementsBySport($sportId);
    }

    public function actionGetMeasurementsByName() {
        $name = \Yii::$app->request->getQueryParam('measurementName');
        if (empty($name)) {
            throw new BadRequestHttpException("Invalid measurement name");
        }
        $results = $this->measurementsUtil->getMeasurementsByName(strtolower($name));
        if (empty($results)) {
            throw new NotFoundHttpException("No measurements found with " .
                "name [" . $name . "]");
        }

        \Yii::$app->response->format = Response::FORMAT_JSON;
        return $results;
    }

}