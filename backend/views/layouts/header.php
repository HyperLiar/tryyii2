<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">后台</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

			<div class="pull-right">
			<?= '<li>'.Html::beginForm(['/site/logout'], 'post')
			.Html::submitButton(
					'注销（'.Yii::$app->user->identity->username.')',
					['class' => 'btn btn-info']
			). Html::endForm().'</li>'
			?>
			</div>
            </ul>
        </div>
    </nav>
</header>
