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
		<h3>用户详情</h3>
		<?php $form=ActiveForm::begin(); 
			$user->role = $userInfo['role'];
		?>


		<ul>
			<label>用户名</label>:<?= Html::textInput('username',$userInfo['username'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<label>真实姓名</label>:<?= Html::textInput('name',$userInfo['name'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<label>专业</label>:<?= Html::textInput('pro',$userInfo['pro'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<label>手机号</label>:<?= Html::textInput('phone',$userInfo['phone'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<label>电子邮箱</label>:<?= Html::textInput('email',$userInfo['email'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<label>居住地址</label>:<?= Html::textInput('address',$userInfo['address'], ['class' => 'form-control', 'readonly' => 'readonly']) ?>
			<?php if($role == 40) { ?>
			<?= $form->field($user, 'role')->dropDownList(['10' => '普通用户', '20' => '普通编辑', '30' => '专家', '40' => '主编']); ?>
				<?php } ?>
		</ul>
		<?php if($role == 40) { ?>
		<div class="form-group col-lg-2">
			<?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
		</div>
		<?php } ?>
		<?php ActiveForm::end(); ?>
		</div>
		<div class = col-lg-5>
	<h3>用户投稿</h3>
		<?php if(!empty($error)) {?>
			<?= Html::encode($error); ?>
		<?php } else { ?>
		<table class="table table-boarded table-striped">
			<thead><tr>
			<td>标题</td>
			<td>专业</td>
			<td>审核状态</td>
			<td>创建时间</td>
			</tr></thead><tbody>
		<?php foreach($essayList as $essay) { 
			$url = "http://localhost/essayonline/backend/web/site/infoessay?id=".$essay['id'];
			?>
			<tr><td><a href="<?= $url; ?>"><?= $essay['title']; ?></a></td>
				<td><?= $essay['pro']; ?></td>
				<td><?= $essay['status_message']; ?></td>
				<td><?= Date('Y-m-d H:i:s', $essay['ctime']); ?></td>
				</tr>
		<?php } ?>
		</tbody></table>
		<?php } ?>
		</div>
	</div>
</div>
