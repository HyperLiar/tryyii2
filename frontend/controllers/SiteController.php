<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\models\LoginForm;
use common\models\User;
use common\models\Essay;
use common\models\Review;
use common\models\ProOther;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
			'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
			'upload' => [
				'class' => 'kucha\ueditor\UEditorAction',
				'config' => [
					/* 上传文件配置 */
					"fileActionName"          => "uploadfile",
					/* controller里,执行上传视频的action名称 */
					"fileFieldName"           => "upfile",
					/* 提交的文件表单名称 */
					"filePathFormat"          => "/upload/file/{yyyy}{mm}{dd}/{time}{rand:6}",
					/* 上传保存路径,可以自定义保存路径和文件名格式 */
					"fileUrlPrefix"           => "/upload/prefix/",
					/* 文件访问路径前缀 */
					"fileMaxSize"             => 51200000,
					/* 上传大小限制，单位B，默认50MB */
					"fileAllowFiles"          => [
						".doc",
					".docx",
					".xls",
					".xlsx",
					".ppt",
					".pptx",
					".pdf",
					".txt",
					],  
				]   
			], 
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

	/**
	 * @desc 最新文稿展示
	 *
	 */
	public function actionEssay() {
		$essay = new Essay;
		$essayList = $essay->fetchEssayListRankByStatus(0,0);	
		$count = count($essayList);
		$pages = new Pagination(['totalCount' => $count, 'pageSize' => '20']);
		if ($count > 0) {
			return $this->render('essay', [
				'essayList'	=> $essayList,
				'pages'		=> $pages,
			]);
		} else {
			return $this->render('essay', [
				'error'		=> '还没有人上传过稿件',
				'pages'		=> $pages,
			]);
		}	}

	/**
	 * @desc 个人文稿-展示
	 *
	 */
	public function actionMyessay() {
		$essay = new Essay;
		$uid = Yii::$app->user->getId();
		$essayList = $essay->fetchEssayByUid($uid);	
		$count = count($essayList);
		$pages = new Pagination(['totalCount' => $count, 'pageSize' => '20']);
		if ($count > 0) {
			return $this->render('myessay', [
				'essayList'	=> $essayList,
				'pages'		=> $pages,
			]);
		} else {
			return $this->render('myessay', [
				'error'		=> '您还没有上传过稿件',
				'pages'		=> $pages,
			]);
		}
	}

	/**
	  * @desc 个人文稿-添加
	  *
	  */
	public function actionAddmyessay() {
		$essay = new Essay;
		if($essay->load(Yii::$app->request->post()) && $essay->validate()){
			$params = Yii::$app->request->post('Essay');
			$params['uid'] = Yii::$app->user->getId();
			//var_dump(iconv('utf-8','cp936', $params['title']));die();
			$add = $essay->createEssay($params);
			if ($add) {
				Yii::$app->session->setFlash('success','文章添加成功');
				$url = "http://localhost/essayonline/frontend/web/site/myessay";
				return $this->redirect($url, 302);
			} else {
				Yii::$app->session->setFlash('error','文章添加失败');
				return $this->render('addmyessay', [
						'essay' => $essay,
				]);
			}
		}

		return $this->render('addmyessay',[
				'essay'=>$essay,
		]);
	}

	/**
	  * @desc 个人文稿 详情
	  *
	  */
	public function actionInfomyessay() {
		$essay = new Essay;
		$review = new Review;
		$id = Yii::$app->request->get('id');
		$info = $essay->fetchEssayById($id);
		$rev = $review->fetchReviewByUid(array('e_id' => $id));
		if (!empty($info)) {
			return $this->render('infomyessay', [
				'essay'	=> $info,
				'rev'=> $rev,
			]);
		} else {
			return $this->render('infomyessay', [
				'error'	=> '获取失败',
				'rev'	=> $rev,
			]);
		}
	}

	/**
	  * @desc 修改资料
	  *
	  */
	public function actionMydata() {
		$user = new User;
		$id = Yii::$app->user->getId();
		$updateParams = Yii::$app->request->post('User');
		if (!empty($updateParams)) {
			$updateParams['id'] = $id;
			$updateResult = $user->updateUser($updateParams);
			if ($updateResult) {
				Yii::$app->session->setFlash('success','更新成功');
			} else {
				Yii::$app->session->setFlash('error','更新失败，请重试');
			}
		}

		$info = $user->selectUserById($id);
		if (empty($info['address'])) {
			$info['address'] = '未填写';
		}
		return $this->render('mydata',[
				'user'		=> $user,
				'info'		=> $info,
		]);
	}

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', '请检查您的邮箱！');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', '抱歉，未能根据您提供的邮箱重设密码！');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', '新密码设置成功');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
