<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

$this->title = '待操作投稿';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-statusessay">
    <h3>待操作投稿:</h3>
	<?php $form = ActiveForm::begin(); ?>
	<ul>
	<?= $form->field($essay,'status')->dropDownList(['0'=>'待编辑分发','1'=>'待专家审核','2'=>'待主编确认','3'=> '已审核成功','4'=>'已失败'])->label('审核状态'); ?>
	<?= Html::submitButton('筛选',['class' => 'btn btn-primary', 'name' => 'update-button']); ?>
	</ul>
	<?php ActiveForm::end(); ?>
	<?php if (empty($essayList)) { ?>
		<h4><?= Html::encode($error); ?></h4>
	<?php } else { ?>
	
	<?php foreach ($essayList as $essay) {
				$url = "http://localhost/essayonline/backend/web/site/infoessay?id=".$essay['id'];
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
