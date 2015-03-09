<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class ItemRequestAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/ItemRequest.css'
    ];
    public $js = [
        'js/ItemRequest.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}