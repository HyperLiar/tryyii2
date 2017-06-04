<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = '我的投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-infoessay">

	<ul>
	<li><label>标题</label>:<?= Html::encode($info['title']) ?></li>
	<li><label>内容</label>:<br /><?= Html::textarea('content', $info['content'], ['rows' => 10,'cols' => 180, 'readonly' => 'readonly']) ?></li>
	<li><label>审核状态</label>:<?= Html::encode($info['status_message']) ?></li>
	<li><label>出版状态</label>:<?= Html::encode($info['status_message']) ?></li>
	<li><label>创建时间</label>:<?= Html::encode(Date('Y-m-d H:i:s',$info['ctime'])) ?></li>
	<li><label>更新时间</label>:<?= Html::encode(Date('Y-m-d H:i:s',$info['utime'])) ?></li>
	
	</ul>

</div>
