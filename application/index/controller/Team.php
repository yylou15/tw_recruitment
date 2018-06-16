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
     * 创建队伍
     */
    public function setupTeam(Request $request){
        $data['status'] = false;
        $data['message'] = '';
        $val = $request->post();
        $team = new TeamModel();
        if($res = $team->setupTeam($val)){
            $data['status'] = true;
            $data['message'] = $res;
        }else{
            $data['message'] = "队伍已存在";
        }
        return json_encode($data);
    }
}