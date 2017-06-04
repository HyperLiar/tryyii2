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
						'actions' => ['logout', 'index','statusessay','infoessay','userlist','hisdata','mydata'],
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
		$params = Yii::$app->request->post('Essay');
		$status = empty($params['status']) ? 0 : $params['status'];
		$essay->status = $status;

		$role = Yii::$app->user->identity->role;
		if ($role == 30) {
			$pro = Yii::$app->user->identity->pro;
			$essayList = $essay->fetchEssayByProAndStatus($pro);
		} else if ($role == 20) {
			$status = 0;
			$essayList = $essay->fetchEssayListByStatus($status,0,0);
		} else {
			$essayList = $essay->fetchEssayListByStatus($status,0,0);
		}
		$count = count($essayList);
		$pages = new Pagination(['totalCount' => $count, 'pageSize' => '20']);
		if ($count <= 0) {
			return $this->render('statusessay',[
					'error' => '无待操作的文稿',
					'pages' => $pages,
					'essay'=> $essay,
			]);	
		} else {
			return $this->render('statusessay', [
				'essayList'	=> $essayList,
				'pages'		=> $pages,
				'essay'		=> $essay,
			]);
		}
	}

	/**
	  * @desc show essay info
	  *
	  */
	public function actionInfoessay() {
		$essay = new Essay;
		$review = new Review;
		$user = new User;
		$id = Yii::$app->request->get('id');
		$essayInfo = $essay->fetchEssayById($id);
		$role = Yii::$app->user->identity->role;
		$params = Yii::$app->request->post('Essay');

		$proList = array();
		if($role == 20) {
			$pro = empty($params['pro']) ? '1' : $params['pro'];
			$proList = $user->fetchUserByPro();
		} else if ($role == 30){
			$params['status'] = 2;
		}


		if (isset($params['status'])) {
			if ($params['status'] - $essayInfo['status'] != 0) {
			$publish_time = empty($params['publish_time']) ? 0 : $params['publish_time'];
			$publish_ver  = empty($params['publish_ver']) ? '' : $params['publish_ver'];
			$payment = empty($params['payment']) ? '' : $params['payment'];
			$update = $essay->updateEssayStatus($id, $params['status'],$publish_time,$publish_ver,$payment);
			$reviewParams = array(
				'u_id'	=> Yii::$app->user->getId(),
				'e_id'	=> $id,
				'start_status'	=> $essayInfo['status'],
				'end_status'	=> $params['status'],
				'comment'		=> empty($params['comment']) ? '无审批意见' : $params['comment'],
				'username'		=> Yii::$app->user->identity->username,
			);
			$createReview = $review->createReview($reviewParams);
			}

			$rev = $review->fetchReviewByUid(array('e_id' => $id));
			if ($update) {
				Yii::$app->session->setFlash('success', '更新成功');
				$essayInfo = $essay->fetchEssayById($id);
				return $this->render('infoessay',['essay' => $essay, 'essayInfo' => $essayInfo, 'rev' => $review, 'proList' => $proList]);
			} else {
				Yii::$app->session->setFlash('error', '更新失败');		
				return $this->render('infoessay',['essay' => $essay, 'essayInfo' => $essayInfo, 'rev' => $review, 'proList' => $proList]);
			}
		} else {
			$rev = $review->fetchReviewByUid(array('e_id' => $id));
			return $this->render('infoessay', ['essay' => $essay, 'essayInfo' => $essayInfo, 'rev' => $review, 'proList' => $proList]);
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
		$pages = new Pagination(['totalCount' => $count, 'pageSize' => 20]);

		if ($count > 0) {
			return $this->render('userlist', [
				'userList'	=> $userList ,
				'pages'		=> $pages,
			]);
		} else {
			return $this->render('userlist', [
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
		$id = Yii::$app->request->get('id');
		$userInfo = $user->selectUserById($id);	
		$essayList = $essay->fetchEssayByUid($id);
		$count = count($essayList);
		$pages = new Pagination(['totalCount' => $count, 'pageSize' => 20]);

		$params = Yii::$app->request->post('User');
		if (!empty($params) && $params['role'] != $userInfo['role']) {
			$params['id'] = $id;
			$updateUser = $user->updateUser($params);
			$userInfo = $user->selectUserById($id);
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

	/**
	  * @desc my data
	  *
	  */
	public function actionMydata() {
		$user = new User;
		$id = Yii::$app->user->getId();
		$userInfo = $user->selectUserById($id);
		$params = Yii::$app->request->post('User');
		if (!empty($params)) {
			if ($params['phone']!=$userInfo['phone'] || $params['email'] != $userInfo['email']
				|| $params['address']!=$userInfo['address']) {
				$params['id'] = $id;
				$updateUser = $user->updateUser($params);
				if ($updateUser) {
					Yii::$app->session->setFlash('success', '更新成功');
					$userInfo = $user->selectUserById($id);
					return $this->render('mydata',[
						'userInfo'	=> $userInfo,
						'user'		=> $user,
					]);
				} else {
					Yii::$app->session->setFlash('error', '更新失败');
				}
			}
		}
		return $this->render('mydata', [
			'userInfo'		=> $userInfo,
			'user'			=> $user,
		]);
	}
}
