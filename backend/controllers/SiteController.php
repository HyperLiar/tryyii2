<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use common\models\LoginForm;
use common\models\User;
use common\models\Essay;
use common\models\Review;
use common\models\ProOther;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
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
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

	/**
	  * @desc show essay action
	  *
	  */
	public function actionStatusessay() {
		$essay = new Essay;
		$params = Yii::$app->getRequest->post('params');

		$essayList = $essay->fetchEssayListByStatus($params);
		$count = count($essayList);
		$pages = new Pagination(['totalCount' => $count, 'pageSize' => '20']);
		if ($count <= 0) {
			return $this->render('statusessay',[
					'error' => '无待操作的文稿',
					'pages' => $pages,
			]);	
		} else {
			return $this->render('statusessay', [
				'essayList'	=> $essayList,
				'pages'		=> $pages,
			]);
		}
	}

	/**
	  * @desc show essay info
	  *
	  */
	public function actionInfoessay() {
		$essay = new Essay;
		$id = Yii::$app->getRequest->get('id');
		$essayInfo = $essay->fetchEssayById($id);

		$params = Yii::$app->getRequest->post('params');
		if ($params['status'] != $essayInfo['status']) {
			$publish_time = empty($params['publish_time']) ? 0 : $params['publish_time'];
			$publish_ver  = empty($params['publish_ver']) ? '' : $params['publish_ver'];
			$payment = empty($params['payment']) ? '' : $params['payment'];
			$update = $essay->updateEssayStatus($id, $params['status'],$publish_time,$publish_ver,$payment);

			if ($update) {
				Yii::$app->session->setFlash('success', '更新成功');
				$essayInfo = $essay->fetchEssayById($id);
				$this->render('infomyessay',['essay' => $essay, 'info' => $essayInfo]);
			} else (
				Yii::$app->session->setFlash('error', '更新失败');		
			)
		} else {
			$this->render('infomyessay', ['essay' => $essay, 'info'	=> $essayInfo]);
		}
	}

	/**
	  * @desc show user list
	  *
	  */
	public function actionUserlist() {
		$user = new User;
		$userList = $user->fetchUserList();
		$count = count($userList);
		$pages = new Pagination('totalCount' => $count, 'pageSize' => 20);

		if ($count > 0) {
			return $this->render('userlist', [
				'userList'	=> $userList ,
				'pages'		=> $pages,
			]);
		} else {
			return $this->render('userList', [
				'error'	=> '未找到用户',
				'pages'	=> $pages,
			]);
		}
	}

	/**
	  * @desc his data
	  *
	  */
	public function actionHisdata () {
		$user = new User;
		$essay = new Essay;
		$id = Yii::$app->user->getId();
		$userInfo = $user->fetchUserById($id);	
		$essayList = $user->fetchEssayByUid($uid);
		$count = count($essayList);
		$pages = new Pagination('totalCount' => $count, 'pageSize' => 20);

		$params = Yii::$app->getRequest->post('params');
		if ($params['role'] != $userInfo['role'] || $params['status'] != $userInfo['status']) {
			$params['id'] = $id;
			$updateUser = $user->updateUser($params);
			if ($updateUser) {
				Yii::$app->session->setFlash('success', '更新成功');
			} else {
				Yii::$app->session->setFlash('error', '更新失败');
			}
		}

		if ($count > 0) {
			return $this->render('hisdata', [
				'userInfo'	=> $userInfo,
				'user'		=> $user,
				'pages'		=> $pages,
				'essayList' => $essayList,
			]);
		 } else {
			return $this->render('hisdata', [
				'userInfo'	=> $userInfo,
				'user'		=> $user,
				'pages'		=> $pages,
				'error'		=> '该用户尚未提交文稿',
			]);
		 }
	}

}
