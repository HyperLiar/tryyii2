<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimeStampBehavior;
use yii\db\ActiveRecord;
use common\models\ConstStatus;

/**
 * Desc: essay model
 * Date: 2017/5/14
 * Time: 19:57
 */
class Essay extends ActiveRecord {

	public $title;
	public $content;
	public $status = 0;
	public $uid;
	public $publish_time;
	public $publish_ver;
	public $payment;
	public $pro;

	/**
	  * @desc rules
	  *
	  */
	public function rules() {
		return [
			[['title','content'],'required'],
		];
	}

	/**
	  * @desc attributeLabel
	  *
	  */
	public function attributeLabels() {
		return [
			'title'		=> '标题',
			'content'	=> '内容',
			'status_message' => '审核状态',
		];
	}

    /**
     * @desc fetch essay list ranked by status
     * @date 2017_05_14
     */
    public function fetchEssayListRankByStatus ($start_time, $end_time, $status=0) {
        if (empty($start_time)) {
            $start_time = strtotime('-1 week');
        }

        if (empty($end_time)) {
            $end_time = time();
        }

        $sqlWhere = "where ctime>={$start_time} and ctime<={$end_time} and status={$status} order by status desc";
        $sql = "select * from essay " . $sqlWhere;
        $re = Yii::$app->db->createCommand($sql)->queryAll();
        return $re;
    }

    /**
     * @desc fetch essay list by status
     * @date 2017_05_14
     */
    public function fetchEssayListByStatus ($status, $start_time, $end_time) {
        if (empty($start_time)) {
            $start_time = strtotime('-1 week');
        }

        if (empty($end_time)) {
            $end_time = time();
        }

        $sqlWhere = "where ctime>={$start_time} and ctime <= {$end_time} and status={$status}";
        $sql = "select * from essay " . $sqlWhere;
        $re = Yii::$app->db->createCommand($sql)->queryAll();
        return $re;
    }

    /**
     * @desc fetch essay by id
     * @date 2017_05_14
     */
    public function fetchEssayById($id) {
        $sql = "select * from essay where id={$id}";
        $re = Yii::$app->db->createCommand($sql)->queryOne();
        return $re;
    }

    /**
     * @desc fetch essay by uid
     * @date 2017_05_14
     */
    public function fetchEssayByUid($uid) {
        $sql = "select * from essay where uid={$uid}";
        $re = Yii::$app->db->createCommand($sql)->queryAll();
        return $re;
    }

	public function fetchEssayByProAndStatus($pro,$status=1) {
		$sql = "select * from essay where pro={$pro} and status={$status}";
		$re = Yii::$app->db->createCommand($sql)->queryAll();
		return $re;
	}

    /**
     * @desc create essay
     * @date 2017_05_14
     */
    public function createEssay ($params) {
		$params['status'] = ConstStatus::ESSAY_STATUS_START;	
		$params['status_message'] = '等待编辑分发';
        $ctime = $utime = time();
        $sql = "insert into essay (uid,title,content,status,ctime,utime,status_message,pro) values 
                ('{$params['uid']}','{$params['title']}','{$params['content']}',
                '{$params['status']}','{$ctime}','{$utime}','{$params['status_message']}','{$params['pro']}')";
        $re = Yii::$app->db->createCommand($sql)->execute();

        return $re;
    }

    /**
     * @desc update status (publish_time) (publish_version) (payment) by id
     * @date 2017_05_14
     */
    public function updateEssayStatus($id, $status, $publish_time=0, $publish_version='',$payment=0) {
        $utime = time();
        $sql = "update essay set status='{$status}' and utime='{$utime}'";
        if ($status == ConstStatus::ESSAY_STATUS_SUCCESS) {
            $sql .= "and publish_time = '{$publish_time}' and publish_version = '{$publish_version}' and payment = '{$payment}'";
        }
        $sql .= "where id = '{$id}'";

        $re = Yii::$app->db->createCommand($sql)->execute();
        return $re;
    }
}
