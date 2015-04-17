<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class ProfileAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/Profile.css',
    ];
    public $js = [
        'js/Profile.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}