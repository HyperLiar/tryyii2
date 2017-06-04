<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '最新投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-myessay">
    <h3>最新投稿:</h3>
	<table class="table table-boarded table-striped"/>
	<thead><tr>
	<td class='col-md-2 col-xs-2'>标题</td>
	<td class='col-md-2 col-xs-2'>作者</td>
	<td class='col-md-1 col-xs-1'>专业</td>
	<td class='col-md-1 col-xs-1'>创建时间</td>
	</tr></thead><tbody>
	<?php foreach ($essayList as $essay) {
				$url = "http://localhost/essayonline/frontend/web/site/infomyessay?id=".$essay['id'];
				?><tr>
				<td class='col-md-2 col-xs-2'><a href="<?php echo $url ?>"><?= $essay['title']; ?></a></td>
				<td class='col-md-2 col-xs-2'><?= '作者'; ?></td>
				<td class='col-md-4 col-xs-4'><?= '专业'; ?></td>
				<td class='col-md-2 col-xs-2'><?= Date('Y-m-d H:i:s', $essay['ctime']); ?></td>
				</tr>
			<?php } ?>
			</tbody>
			</table>
			<?= LinkPager::widget([
					'pagination'	=> $pages,
					'prevPageLabel' => '上一页',
					'nextPageLabel' => '下一页',
					'hideOnSinglePage'=> false,
			]); ?>
</div>
