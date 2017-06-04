<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '我的投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-myessay">
    <h3>您过去的投稿:</h3>
	<?php if($error != null) {?>
			<h4><?= Html::encode($error) ?></h4>
	<?php } else {
			foreach ($essayList as $essay) {
				$url = "http://localhost/essayonline/frontend/web/site/infomyessay?id=".$essay['id'];
				?>
				<li>
					<div class="page-header"><a href="<?php echo $url ?>"><?= $essay['title']; ?></a></div>
					<div class="content"><?= Date('Y-m-d H:i:s', $essay['ctime']); ?></div>
					<div class="content"><?= $essay['status_message']; ?></div>
				</li>
			<?php } ?>
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
