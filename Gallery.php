<?php
/**
 * Created by PhpStorm.
 * User: borsosalbert
 * Date: 2014.08.13.
 * Time: 20:29
 */

namespace albertborsos\yii2gallery;

use albertborsos\yii2cms\models\GalleryPhotos;
use albertborsos\yii2lib\helpers\S;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\widgets\LinkPager;

class Gallery extends Widget {
    public $htmlOptions = [];
    public $pluginOptions = [];

    public $items = [];

    public $header;
    public $galleryId;

    public $pager;
    public $page = 0;
    public $pageSize = 6;
    public $itemNumInRow = 3;
    public $order = 'ASC';

    public $displayControl = false;

    public function init()
    {
        parent::init();
        $this->htmlOptions['id'] = S::get($this->htmlOptions, 'id', $this->getId());
        $this->pluginOptions['container'] = '#'.$this->htmlOptions['id'].'-gallery';
    }

    public function run()
    {
        echo Html::beginTag('div', ['id' => 'gallery-container', 'data-id' => $this->galleryId]);
            echo Html::beginTag('div', ['id' => 'gallery-'.$this->galleryId.'-before', 'style' => 'display:none;']);
            echo Html::endTag('div');
            if(!empty($this->items)){
                if (!is_null($this->header)){
                    echo Html::tag('h3', $this->header, ['style' => 'text-align:center;']);
                }
                $this->renderLinks();
                $this->registerClientScripts();
            }
            echo Html::beginTag('div', ['id' => 'gallery-'.$this->galleryId.'-after', 'style' => 'display:none;']);
            echo Html::endTag('div');
        echo Html::endTag('div');
    }

    private function renderLinks(){
        echo $this->getPager();
        $models = GalleryPhotos::findAll([
            'status' =>'a',
            'gallery_id' => $this->galleryId,
        ]);

        echo Html::beginTag('div', $this->htmlOptions);
        $n = 0;
        foreach($models as $model){
            if ($n == 0){
                echo Html::beginTag('div', ['class' => 'row']);
            }

            $url = $model->getUrlFull();
            $src = $model->getUrlFull(true);
            $options = [
                'data-rel' => 'lightbox[gallery-'.$model->gallery_id.']',
                'title' => $model->title,
            ];

            echo Html::beginTag('div', ['class' => 'span4 photo-item']);
            echo Html::a(Html::img($src), $url, $options);
            echo Html::endTag('div');

            $n++;
            if ($n == $this->itemNumInRow){
                echo Html::endTag('div');
                $n = 0;
            }
        }
        echo Html::endTag('div');
        echo $this->getPager();
    }

    private function getPager(){
        if (is_null($this->pager)){
            $query = GalleryPhotos::find()->where([
                'status' => 'a',
                'gallery_id' =>$this->galleryId,
            ]);
            $pagination = new Pagination(['totalCount' => $query->count()]);
            $this->pager = LinkPager::widget([
                'pagination' => $pagination,
            ]);

        }
        return $this->pager;
    }

    private function registerClientScripts(){

    }
}