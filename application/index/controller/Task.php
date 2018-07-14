<?php
/**
 * Created by PhpStorm.
 * User: lou
 * Date: 2018/6/27
 * Time: 12:50
 */

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Team as TeamModel;
use app\index\model\Sign as SignModel;
use app\index\model\Task as TaskModel;
class Task
{
    public function creatTask(Request $request){
        $data['status'] = false;
        $task = new TaskModel();
        $val = $request->post();
        return json_encode($task->creatTask($val));
    }

    public function getTask(Request $request){
        $data['status'] = false;
        $task = new TaskModel();
        $taskID = $request->get('taskid');
        $openId = $request->get('openid');
        if($taskID){
            if($res = $task->getTask(1,$taskID)){
                $data['status'] = true;
                $data['data'] = $res;
            }else{
                $data['msg'] = '没有该条记录';
            };
        }elseif($openId){
            if($res = $task->getTask(2,$openId)){
                $data['status'] = true;
                $data['data'] = $res;
            }else{
                $data['msg'] = '没有该条记录';
            };
        }
        return json_encode($data);
    }
}