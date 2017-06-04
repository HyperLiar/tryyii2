<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use \kucha\ueditor\UEditor;
use yii\widgets\ActiveForm;

$this->title = '我的投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-essayadd">
    <h1><?= Html::encode($this->title) ?></h1>
    <h3>您可以在下方编辑新的投稿:</h3>

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($essay, 'title')->label('标题') ?>

	<?=	$form->field($essay, 'content')->textarea(['rows' => 10, 'cols' => 180])->label('内容'); ?>

	<?= $form->field($essay, 'pro')->label('所属专业') ?>
	<div class='form-group'>
		<?= Html::submitButton('提交',['class' => 'btn btn-primary','name' => 'submit-button']) ?>
	</div>

	<?php ActiveForm::end(); ?>
</div>
