<?php
namespace common\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimeStampBehavior;
use yii\db\ActiveRecord;
use common\models\ConstStatus;

/**
 * Desc: review record
 * Date: 2017/5/14
 * Time: 22:54
 */
class Review extends ActiveRecord {
    /**
     * @desc add review record
     * @date 2017_05_14
     */
    public function createReview($params) {
        $params['ctime'] = time();
        $sql = "insert into review (u_id, e_id, start_status, end_status, ctime, comment,username) VALUES 
              ('{$params['u_id']}','{$params['e_id']}','{$params['start_status']}','{$params['end_status']}',
              '{$params['ctime']}','{$params['comment']}','{$params['username']}')";

        $re = Yii::$app->db->createCommnad($sql)->execute();
        return $re;
    }

    /**
     * @desc fetch review record by (u_id) (e_id)
     * @date 2017_05_14
     */
    public function fetchReviewByUid($params) {
        $sql = "select * from review where ";
        $sqlWhere = '';
        if (isset($params['u_id'])) {
            $sqlWhere .= "u_id = {$params['u_id']}";
        }

        if (isset($params['e_id'])) {
            $sqlWhere .= "e_id = {$params['e_id']}";
        }

        $sql .= $sqlWhere;
        $re = Yii::$app->db->createCommand($sql)->queryAll();
        return $re;
    }

}
