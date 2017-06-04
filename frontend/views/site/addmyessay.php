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
    <h3>您过去的投稿:</h3>

    <h3>您可以在下方编辑新的投稿:</h3>

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($essay, 'title') ?>

	<?=	$form->field($essay, 'content')->widget('kucha\ueditor\UEditor',[
			'name'	=> 'new_essay',
			'id'	=> 'new_essay',
			'clientOptions' => [
			//编辑区域大小
			'initialFrameHeight' => '400',
			//设置语言
			'lang' =>'zh-cn', //中文为 zh-cn
			//定制菜单
			'toolbars' => [
				[
					'fullscreen', 'source', 'undo', 'redo', '|',
					'fontsize',
					'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
					'formatmatch', 'autotypeset', '|',
					'forecolor', 'backcolor', '|',
					'lineheight', '|',
					'indent', '|'
					],
				],
			] 
	]) ?>

	<div class='form-group'>
		<?= Html::submitButton('提交',['class' => 'btn btn-primary','name' => 'submit-button']) ?>
	</div>

	<?php ActiveForm::end(); ?>
</div>
