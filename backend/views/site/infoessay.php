<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '投稿详情';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-infoessay">

	<ul>
	<li><label>标题</label>:<?= Html::encode($essayInfo['title']) ?></li>
	<li><label>内容</label>:<br /><?= Html::textarea('content', $essayInfo['content'], ['rows' => 10,'cols' => 180, 'readonly' => 'readonly']) ?></li>
	<li><label>专业</label>:<?= Html::encode($essayInfo['pro']) ?></li>
	<li><label>当前审核状态</label>:<?= Html::encode($essayInfo['status_message']) ?></li>
	<li><label>出版状态</label>:<?= Html::encode($essayInfo['status_message']) ?></li>
	<li><label>创建时间</label>:<?= Html::encode(Date('Y-m-d H:i:s',$essayInfo['ctime'])) ?></li>
	<li><label>更新时间</label>:<?= Html::encode(Date('Y-m-d H:i:s',$essayInfo['utime'])) ?></li>
	</ul>

	<?php $role = Yii::$app->user->identity->role;
		 $form = ActiveForm::begin();		
		 if ($role == 20) {
	?>		
			<?= $form->field($essay, 'pro')->dropDownList(ArrayHelper::map($proList,'id','username')); ?>
		<?php } else if ($role == 30) { ?>
			<?= $form->field($essay, 'comment')->textInput()->label('输入评论'); ?>
		<?php } else if ($role == 40) { ?>
			<?= $form->field($essay, 'publish_time')->textInput()->label('出版时间'); ?>
			<?= $form->field($essay, 'publish_ver')->textInput()->label('发行版本'); ?>
			<?= $form->field($essay, 'payment')->textInput()->label('稿费'); ?>
		<?php } ?>
		<?= Html::submitButton('提交',['class' => 'btn btn-primary', 'name' => 'update-button']); ?>
		<?php ActiveForm::end(); ?>

	<h3>审核状态</h3>
	<?php if(empty($rev)) { ?>
		<h4>尚未审核</h4>
			<?php } else { ?>
				<table class="table table-boarded table-striped">
					<thead><tr>
					<td>审核人</td>
					<td>起始审核状态</td>
					<td>结束审核状态</td>
					<td>审核备注</td>
					<td>审核时间</td>
					</tr></thead><tbody>
					<?php foreach ($rev as $re) { 
						$status_arr = array(
								'0' => '待编辑分发',
								'1' => '待专家审核',
								'2' => '待主编确认',
								'3' => '已审核成功',
								'4' => '已失败',
								);  
						?>  
							<tr><td><?= $re['username']; ?></td>
							<td><?= $status_arr[$re['start_status']]; ?></td>
							<td><?= $status_arr[$re['end_status']]; ?></td>
							<td><?= $re['comment']; ?></td>
							<td><?= Date('Y-m-d H:i:s',$re['ctime']); ?></td></tr>
					<?php } ?>
			</tbody></table>
	<?php } ?>
</div>
