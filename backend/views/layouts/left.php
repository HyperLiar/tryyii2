<?php
use yii\helpers\Html;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>
                <p><i class="fa fa-circle text-success"></i> 在线</p>
            </div>
			<br />
			<br />
        </div>

		<br />

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => '工作', 'options' => ['class' => 'header']],
                    ['label' => '登录', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => '待处理文稿', 'url' => ['site/statusessay']],
                    ['label' => '用户列表', 'url' => ['site/userlist']],
                    ['label' => '我的资料', 'url' => ['site/mydata']],
                ],
            ]
        ) ?>

    </section>

</aside>
