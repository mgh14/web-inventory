<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class CollectionsAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/Collections.css',
    ];
    public $js = [
        'js/Collections.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}