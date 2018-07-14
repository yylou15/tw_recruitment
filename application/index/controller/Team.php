<?php
/**
 * Created by PhpStorm.
 * User: USER9
 * Date: 2018/6/17
 * Time: 5:02
 */


/*
 * team控制器主要负责团队的建立，团队信息管理
 */
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Team as TeamModel;
class team extends Controller
{

    /*
     * 队长创建队伍
     */
    public function setupTeam(Request $request){
        $data['status'] = false;
        $data['message'] = '';
        $val = $request->post();
        $team = new TeamModel();
        if($team->checkCaptain($val)){
            if($res = $team->setupTeam($val)){
                $data['status'] = true;
                $data['message'] = $res;
            }else{
                $data['message'] = "队伍已存在";
            }
        }else{
            $data['message'] = '认证失败';
        }
        return json_encode($data);
    }
    /*
     * 队员绑定队伍
     */
    public function bindTeam(Request $request){
        $val = $request->post();
        $team = new TeamModel();
        return json_encode($team->bindTeam($val));
    }
    /*
     * 问题反馈
     */
    public function problemSubmit(Request $request){
        $val = $request->post();
        $team = new TeamModel();
        return $team->problemSubmit($val);
    }
    /*
     * 队长添加队员
     */
    public function addUser(Request $request){
        $val = $request->post();
        $team = new TeamModel();
        return $team->addUser($val);
    }
    /*
     * 获取队伍和个人信息
     */
    public function getInfo(Request $request){
        $val = $request->post();
        $team = new TeamModel();
        return $team->getInfo($val);
    }
    /*
     * 获取队伍全部信息
     */
    public function getAllInfo(Request $request){
        $val = $request->post();
        $team = new TeamModel();
        return $team->getAllInfo($val);
    }

    /*
     * 获取绑定情况
     */
    public  function getBinding(Request $request){
        $val = $request->post();
        $team = new TeamModel();
        return $team->getBinding($val);
    }

    /*
     * 删除队员
     */
    public  function deleteMember(Request $request){
        $val = $request->post();
        $team = new TeamModel();
        return $team->deleteMember($val);
    }

    /*
     * 提交问题
     */
    public function submitProblem(Request $request){
        $val = $request->post();
        $team = new TeamModel();
        return $team->submitProblem($val);
    }


    /*
     * 获取已绑定的信息
     */
    public  function getBindingInfo(Request $request){

        $val = $request->post();
        $team = new TeamModel();
        return $team->getBindingInfo($val);
    }
}
