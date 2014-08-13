<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace albertborsos\yii2gallery;

use yii\web\AssetBundle;

/**
 * GalleryAsset
 *
 * @package albertborsos\yii2gallery
 */
class GalleryAsset extends AssetBundle
{
    public $sourcePath = '@vendor/albertborsos/yii2-gallery/assets/';

    public $css = [
        'css/style.css'
    ];

    public $js = [
        'js/controller.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
} 