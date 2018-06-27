<?php
/**
 * Created by PhpStorm.
 * User: KIRITO
 * Date: 2018/6/27
 * Time: 10:05
 */

namespace app\index\model;

use think\db;
use think\Model;

class Task extends Model
{
    public function creatTask(){

    }

    public function getTask($mode,$id){
        if($mode==1){
            //任务信息
            $data['details'] = $this->table('zt_shsj_teamtask')->where(['taskid'=>$id])->select();
            //获取该任务下的成员
        }elseif($mode==2){
            $alltask = $this->table('zt_shsj_usertask')->where(['openid'=>$id])->select();
            foreach ($alltask as $key => $value){
                $data = array();
                $data['details'] = array();
                array_push($data['details'],$this->table('zt_shsj_teamtask')->where(['taskid'=>$value['taskid']])->select());
            }
        }
    }
    public function getOneTask($taskID,$openId){

    }

}