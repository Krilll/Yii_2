<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

//use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accessed tasks';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'description:ntext',
            [
                'label' => 'Author',
                'format' => 'raw',

                'value' => function(\app\models\Task $model) {

                    return Html::a ($model->creator->username);
                    //(join($model->getCreator()->select('username')->column()),
                        //['/user/view/', 'id' => $model->creator_id]);
                }
            ],
            'created_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
