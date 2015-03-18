<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class SportsCategoriesAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/Categories.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}