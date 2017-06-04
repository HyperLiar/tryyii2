<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '用户列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-userlist">
	<h3
    <?php if (!empty($error)) { ?>
		<h4><?= Html::encode($error); ?></h4>
	<?php foreach ($essayList as $essay) {
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
</div>
