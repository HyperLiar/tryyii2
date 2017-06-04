<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '个人资料';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-updatemydata">
    <div class="row">
		<div class="col-lg-5">
		<?php $form=ActiveForm::begin(); ?>


		<ul>
			<label>用户名</label>:<?= Html::textInput('username',$info['username'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<label>真实姓名</label>:<?= Html::textInput('name',$info['name'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<label>专业</label>:<?= Html::textInput('name',$info['pro'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<?= $form->field($user,'phone',[
				'inputOptions'	=> [
					'value'		=> $info['phone'],
				]
			])->textInput()->label('手机号'); ?>
			<?= $form->field($user,'email',[
				'inputOptions'	=> [
					'value'		=> $info['email'],
				]
			])->textInput()->label('电子邮箱'); ?>
			<?= $form->field($user,'address',[
				'inputOptions'	=> [
					'value'		=> $info['address'],
				]
			])->textInput()->label('地址'); ?>
		</ul>
		<div class="form-group">
			<?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
		</div>

		<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
