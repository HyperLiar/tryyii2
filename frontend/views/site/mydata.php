<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '个人资料';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-mydata">
    <div class="row">
		<div class="col-lg-5">
		<ul>
			<li><label>用户名</label>:<?= Html::encode($info['username']) ?></li>
			<li><label>手机号</label>:<?= Html::encode($info['phone']) ?></li>
			<li><label>电子邮箱</label>:<?= Html::encode($info['email']) ?></li>
			<li><label>真实姓名</label>:<?= Html::encode($info['name']) ?></li>
			<li><label>地址</label>:<?= Html::encode($info['address']) ?></li>
		</ul>
		<div class="form-group">
			<?= Html::submitButton('修改', ['class' => 'btn btn-primary', 'name' => 'update-button', 'onClick' => "update()"]) ?>
		</div>
		</div>
	</div>
</div>

<script language="javascript" type="text/javascript">
	function update() {
		location = "http://localhost/essayonline/frontend/web/site/updatemydata";
	}
</script>
