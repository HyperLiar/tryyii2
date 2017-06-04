<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-userlist">
    <?php if (!empty($error)) { ?>
		<h4><?= Html::encode($error); ?></h4>
	<?php } else { ?>
	<table class="table table-boarded table-striped">
		<thead><tr>
			<td>用户名</td>
			<td>真实姓名</td>
			<td>手机号</td>
			<td>电子邮箱</td>
			<td>住址</td>
			<td>用户类型</td>
			<td>用户专业</td>
			</tr>
			</thead>
			<tbody>
	<?php foreach ($userList as $user) {
				$url = "http://localhost/essayonline/backend/web/site/hisdata?id=".$user['id'];
				?><tr>
					<td><a href="<?php echo $url ?>"><?= $user['username']; ?></a></td>
					<td><?= $user['name']; ?></td>
					<td><?= $user['phone']; ?></td>
					<td><?= $user['email']; ?></td>
					<td><?= $user['address']; ?></td>
					<td><?php switch($user['role']) {
						case '10': "一般用户";break;
						case '20': "普通编辑";break;
						case '30': "专家";break;
						case '40': "主编";break;
					}; ?></td>
					<td>待定</td></tr>
			<?php } ?>
				</tbody>
				</table>
			<?= LinkPager::widget([
					'pagination'	=> $pages,
					'prevPageLabel' => '上一页',
					'nextPageLabel' => '下一页',
					'hideOnSinglePage'=> false,
			]); ?>
			<?php } ?>
</div>
