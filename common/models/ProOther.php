<?php
namespace common\models;

/**
 * Desc: pro other
 * Date: 2017/5/14
 * Time: 23:14
 */
class ProOther {
    /**
     * @desc add pro_other
     * @date 2017_05_14
     */
    public function insertProOther($params) {
        $sql = "insert into pro_other (other_id, other_type, pro_name, type) values 
                ('{$params['other_id']}','{$params['other_type']}', '{$params['pro_name']}', '{$params['type']}')";
        $re = Yii::app()->db->createCommand($sql)->execute();
        return $re;
    }

    /**
     * @desc select pro_other
     * @date 2017_05_14
     */
    public function fetchProOther($other_id, $other_type, $type=0) {
        $sql = "select * from pro_other where other_id = {$other_id} and other_type = {$other_type} and type = {$type}";
        $re = Yii::app()->db->createCommand($sql)->queryAll();
        return $re;
    }

    /**
     * @desc update pro_other type
     * @date 2017_05_14
     */
    public function updateProOther($other_id, $other_type, $type) {
        $sql = "update pro_other where other_id = {$other_id} and other_type = {$other_type} and type = {$type}";
        $re = Yii::app()->db->createCommand($sql)->execute();
        return $re;
    }
}
