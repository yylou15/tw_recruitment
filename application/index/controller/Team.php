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
}
