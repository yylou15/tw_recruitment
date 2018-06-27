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