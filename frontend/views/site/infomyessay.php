<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use \kucha\ueditor\UEditor;

$this->title = '我的投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-essayadd">

	<h3>投稿详情</h3>
	<ul>
	<li><label>标题</label>:<?= Html::encode($essay['title']) ?></li>
	<li><label>内容</label>:<br /><?= Html::textarea('content', $essay['content'], ['rows' => 10,'cols' => 180, 'readonly' => 'readonly']) ?></li>
	<li><label>所属专业</label>:<?= Html::encode($essay['pro']) ?></li>
	<li><label>审核状态</label>:<?= Html::encode($essay['status_message']) ?></li>
	<li><label>出版状态</label>:<?= Html::encode($essay['publish_version']) ?></li>
	<li><label>创建时间</label>:<?= Html::encode(Date('Y-m-d H:i:s',$essay['ctime'])) ?></li>
	<li><label>更新时间</label>:<?= Html::encode(Date('Y-m-d H:i:s',$essay['utime'])) ?></li>
	
	</ul>

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
			'0'	=> '待编辑分发',
			'1'	=> '待专家审核',
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
