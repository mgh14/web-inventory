<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class SportMeasurementAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery-ui.min.css',
        'css/Measurements.css'
    ];
    public $js = [
        'js/jquery-ui.min.js',
        'js/Measurements.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}