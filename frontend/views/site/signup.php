<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写以下内容注册账号:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('账号名') ?>

                <?= $form->field($model, 'email')->label('电子邮箱') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('密码') ?>

				<?= $form->field($model, 'phone')->textInput()->label('手机号') ?>

				<?= $form->field($model, 'name')->textInput()->label('真实姓名') ?>

				<?= $form->field($model, 'address')->textInput()->label('地址(选填)') ?>

                <div class="form-group">
                    <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
