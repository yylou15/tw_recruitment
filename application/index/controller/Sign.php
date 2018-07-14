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
    public function sign(Request $requst){
////        $timeLong,$taskID,$openId,$longitude,$latitude
            $sign = new SignModel();$data=[];
            $date = date('Y-m-d',time());
            $openId = $requst->post('openid');
            $place = json_decode($requst->post('address'),true);
            $data=$sign->checkTime($openId,$date);
            if(!$data['status'])
                return json_encode($data);
            $data=$sign->checkPlace($place,$openId,$date);
//            if(!$data['status'])
//                return json_encode($data);
            $res = $sign->submit($openId,$place,$data['status']);
            if($res&&$data['status']){
                $data['status'] = true;
            }
            else if($res&&!$data['status']){
                $date['status'] = true;
                $data['msg'] = '成功！但是签到地点有误';
            }else if(!$res){
                $data['status'] = false;
                $data['msg'] = '你今天已经签过到了';
            }
            else{
                $data['status'] = false;
                $data['msg'] = '系统异常！请和管理员联系';
            }
            return json_encode($data);
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


        public function isSign(Request $request){
            $sign = new SignModel();
            $openId = $request->post('openid');
            $data['issign'] = $sign->isSignToday($openId);
            return json_encode($data);
        }


        public function reSign(Request $request){
            $sign = new SignModel();
            $openId = $request->post('openid');
            $data['status'] = $sign->reSign($openId);
            return json_encode($data);
        }
    public function getAll(Request $request){
        $sign = new SignModel();
        $openId = $request->post('openid');
        return $sign->getAll($openId);

    }

}