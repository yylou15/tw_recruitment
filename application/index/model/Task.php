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
    public function creatTask($val){
        $data['status'] = true;
        switch ($val['index']){
            case 1:$arr = [$val['add1']];break;
            case 2:$arr = [$val['add1'],$val['add2']];break;
            case 3:$arr = [$val['add1'],$val['add2'],$val['add3']];break;
        }
        $teamid = $this->table('zt_shsj_user')->where(['openid'=>$val['openid']])->select()[0]['teamid'];
        if($this->table('zt_shsj_team')->where(['teamid'=>$teamid])->select()){
            $this->table('zt_shsj_team')->where(['teamid'=>$teamid])->update(['place'=>json_encode($arr),'starttime'=>$val['begin'],'endtime'=>$val['end']]);
        }else{
            $this->table('zt_shsj_team')->insert(['teamid'=>$teamid,'place'=>json_encode($arr),'starttime'=>$val['begin'],'endtime'=>$val['end']]);
        }
        return json_encode($data);
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