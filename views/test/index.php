<?
/* @var $this yii\web\View */
/* @var $text string */
/* @var $product \app\models\Product  */

use yii\web\View;
?>

<h1><?= $text ?></h1>
<?= \yii\widgets\DetailView::widget(['model' => $product]) ?>