<?php
/**
 * Desc: essay model
 * Date: 2017/5/14
 * Time: 19:57
 */
class Essay {
    /**
     * @desc fetch essay list ranked by status
     * @date 2017_05_14
     */
    public function fetchEssayListRankByStatus ($start_time, $end_time, $offset=0, $limit=20, $is_delete=0) {
        if (empty($start_time)) {
            $start_time = strtotime('-1 week');
        }

        if (empty($end_time)) {
            $end_time = time();
        }

        $sqlWhere = "where ctime>={$start_time} and ctime<={$end_time} and is_delete={$is_delete} order by status desc limit {$offset}, {$limit}";
        $sql = "select * from essay " . $sqlWhere;
        $re = Yii::app()->db->createCommand($sql)->queryAll();
        return $re;
    }

    /**
     * @desc fetch essay list by status
     * @date 2017_05_14
     */
    public function fetchEssayListByStatus ($status, $start_time, $end_time, $offset=0, $limit=20, $is_delete=0) {
        if (empty($start_time)) {
            $start_time = strtotime('-1 week');
        }

        if (empty($end_time)) {
            $end_time = time();
        }

        $sqlWhere = "where ctime>={$start_time} and ctime <= {$end_time} and status={$status} and is_delete={$is_delete} limit {$offset}, {$limit}";
        $sql = "select * from essay " . $sqlWhere;
        $re = Yii::app()->db->createCommand($sql)->queryAll();
        return $re;
    }

    /**
     * @desc fetch essay by id
     * @date 2017_05_14
     */
    public function fetchEssayById($id) {
        $sql = "select * from essay where id={$id}";
        $re = Yii::app()->db->creaetCommand($sql)->queryOne();
        return $re;
    }

    /**
     * @desc fetch essay by uid
     * @date 2017_05_14
     */
    public function fetchEssayByUid($uid, $offset=0, $limit=10,$is_delete=0) {
        if ($is_delete == -1) {
            $sqlWhere = "where uid={$uid} limit {$offset}, {$limit}";
        } else {
            $sqlWhere = "where uid={$uid} limit {$offset}, {$limit}";
        }
        $sql = "select * from essay " . $sqlWhere;
        $re = Yii::app()->db->createCommand($sql)->queryAll();
        return $re;
    }

    /**
     * @desc create essay
     * @date 2017_05_14
     */
    public function createEssay ($params) {
        $ctime = time();
        $sql = "insert into essay (u_id,name,path,extension,status,ctime) values 
                ('{$params['u_id']}', '{$params['name']}','{$params['path']}','{$params['extension']}',
                '{$params['status']}','{$ctime}')";
        $re = Yii::app()->db->createCommanad($sql)->excute();

        return $re;
    }

    /**
     * @desc update status (is_delete) (publish_time) (publish_version) (payment) by id
     * @date 2017_05_14
     */
    public function updateEssayStatus($id, $status, $is_delete=0, $publish_time=0, $publish_version='',$payment=0) {
        $utime = time();
        $sql = "update essay set status='{$status}' and utime='{$utime}'";
        if ($status == ConstStatus::ESSAY_STATUS_SUCCESS) {
            $sql .= "and publish_time = '{$publish_time}' and publish_version = '{$publish_version}' and payment = '{$payment}'";
        }
        if ($status == ConstStatus::ESSAY_STATUS_FAIL && $is_delete != 0) {
            $sql .= "and is_delete = '{$is_delete}'";
        }
        $sql .= "where id = '{$id}'";

        $re = Yii::app()->db->createCommand($sql)->excute();
        return $re;
    }
}