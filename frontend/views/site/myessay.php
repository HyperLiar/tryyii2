<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '我的投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-myessay">
    <h3>您过去的投稿:</h3>
	<?php if(!empty($error)) {?>
			<h4><?= Html::encode($error) ?></h4>
	<?php } else { ?>
	<table class="table table-boarded table-striped">
		<thead><tr>
		<td>标题</td>
		<td>专业类别</td>
		<td>创建时间</td>
		<td>审核状态</td>
		</tr></thead><tbody>
		<?php
			foreach ($essayList as $essay) {
				$url = "http://localhost/essayonline/frontend/web/site/infomyessay?id=".$essay['id'];
				?>
				<tr>
					<td><a href="<?php echo $url ?>"><?= $essay['title']; ?></a></td>
					<td>类别</td>
					<td><?= Date('Y-m-d H:i:s', $essay['ctime']); ?></td>
					<td><?= $essay['status_message']; ?></td>
				</tr>
			<?php } ?>
			</tbody></table>
			<?= LinkPager::widget([
					'pagination'	=> $pages,
					'prevPageLabel' => '上一页',
					'nextPageLabel' => '下一页',
					'hideOnSinglePage'=> false,
			]); ?>
		<?php } ?>
		<br ?>
		<div class='col-md-1'>
		<?= Html::submitButton('添加',['class'=>'btn btn-primary','name' =>'submit-button','onClick' => "add()"]); ?>
		</div>
</div>

<script language="javascript" type="text/javascript">
	function add() {
		location = "http://localhost/essayonline/frontend/web/site/addmyessay";
	}

</script>
