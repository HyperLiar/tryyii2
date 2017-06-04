<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '个人资料';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-updatemydata">
	<br />
	<br />
    <div class="row">
		<div class="col-lg-5">
		<?php $form=ActiveForm::begin();?>


		<ul>
			<label>用户名</label>:<?= Html::textInput('username',$userInfo['username'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<label>真实姓名</label>:<?= Html::textInput('name',$userInfo['name'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<label>专业</label>:<?= Html::textInput('pro',$userInfo['pro'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<?= $form->field($user,'phone',[
				'inputOptions'	=> [
					'value'		=> $userInfo['phone'],
				]
			])->textInput()->label('手机号'); ?>
			<?= $form->field($user,'email',[
				'inputOptions'	=> [
					'value'		=> $userInfo['email'],
				]
			])->textInput()->label('电子邮箱'); ?>
			<?= $form->field($user,'address',[
				'inputOptions'	=> [
					'value'		=> $userInfo['address'],
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
