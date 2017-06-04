<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use \kucha\ueditor\UEditor;

$this->title = '我的投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-essayadd">

	<ul>
	<li><label>标题</label>:<?= Html::encode($essay['title']) ?></li>
	<li><label>内容</label>:<br /><?= Html::textarea('content', $essay['content'], ['rows' => 10,'cols' => 180, 'readonly' => 'readonly']) ?></li>
	<li><label>审核状态</label>:<?= Html::encode($essay['status_message']) ?></li>
	<li><label>出版状态</label>:<?= Html::encode($essay['status_message']) ?></li>
	<li><label>创建时间</label>:<?= Html::encode(Date('Y-m-d H:i:s',$essay['ctime'])) ?></li>
	<li><label>更新时间</label>:<?= Html::encode(Date('Y-m-d H:i:s',$essay['utime'])) ?></li>
	
	</ul>

</div>
