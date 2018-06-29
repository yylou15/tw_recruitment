<?php
/**
 * Created by PhpStorm.
 * User: KIRITO
 * Date: 2018/6/27
 * Time: 10:33
 */

namespace app\index\controller;
use think\Controller;
use think\Request;
use app\index\model\Team as TeamModel;
use app\index\model\Sign as SignModel;
class Sign
{
    /**
     * @param $timeLong 直接用服务器的时间戳不就好
     * @param $taskID
     * @param $openId
     * @param $longitude
     * @param $latitude
     */
    public function sign($timeLong,$taskID,$openId,$longitude,$latitude){
        $sign = new SignModel();
        $data=[];
        $data=$sign->checkTime($data,$taskID);
        if($data['message']!="time success")
            return $data["message"];
        $data=$sign->checkPlace($data,$taskID,$longitude,$latitude);
        if($data['message']!="place success")
            return $data["message"];
        $res = $sign->submit($openId,$taskID,$data);
        if($res)
            return "sign success";
        else
            return 'something wrong';
    }

    public function getSign($taskID,$openId,$startDate,$endDate,$type,$detail){
        $sign = new SignModel();
        switch ($type){
            case "daily": return $sign->getDaily(); break; //
            case "all": return $sign->getAll();break;
            case "individual":
                switch($detail){
                    case "simple": return $sign->getSimple();break;
                    case"late":return $sign->getLate();break;
                    case "leave":return $sign->getLeave();break;
                    case"ontime":return $sign->getOntime();break;
                    case"absent":return $sign->getAbsent();break;
                }
        }
    }
}