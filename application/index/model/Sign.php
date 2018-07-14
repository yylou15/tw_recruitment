<?php
/**
 * Created by PhpStorm.
 * User: KIRITO
 * Date: 2018/6/27
 * Time: 10:10
 */

namespace app\index\model;
use think\Db;

use think\Model;
use think\Request;

class Sign extends Model
{
    public function checkTime($openid,$date){
        $data['status'] = false;
        $teamid = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['teamid'];
        $res = Db::table('zt_shsj_team')->where(['teamid'=>$teamid])->field("starttime,endtime")->select()[0];
        if($res==null){
            $data['msg']="没有相关队伍信息";
        }
        else{
//            $now=time();
//            $start = strtotime($res['starttime']);
//            $end = strtotime($res['endtime']);
            if($date<=$res['starttime'])
                $data['msg']= "未到签到时间";
            elseif ($date>=$res['endtime']){
                $data['msg']= "签到时间已过";
            } else{
//                $data['time']=date("Y-m-d H:i:s");
//                $data["in_time"]="normal";
                $data['status']= true;
            }
        }
        return $data;
    }

    public function checkPlace($place,$openId,$date){
        $data['status'] = false;
        $data['msg'] = '未在指定地点，无法签到';
        $a = array();
        array_push($a,$place['province']);
        array_push($a,$place['city']);
        array_push($a,$place['district']);
        $teamid = $this->table('zt_shsj_user')->where(['openid'=>$openId])->select()[0]['teamid'];
        $res = Db::table('zt_shsj_team')->where(['teamid'=>$teamid])->select()[0]['place'];
        $res = json_decode($res);
        foreach ($res as $key => $value){
            if($value==$a){
                $data['status'] = true;
                unset($data['msg']);
            }
        }
        return $data;
//        if($res==null) {
//            $data['message']="there is no such task";
//        } else{
//            // check place
//            if(1){
//                $data['lng']=$longitude;
//                $data['lat']=$latitude;
//                $data['address']=$res['address'];
//                $data['message']="place success";
//            }else{
//                $data['message']="wrong place";
//            }
//        }
//        return $data;
    }

    public function submit($openId,$place,$in_place){
        $res = $this->table('zt_shsj_user')->where(['openid'=>$openId])->select()[0];
        $place = $place['province'].$place['city'].$place['district'];
        if($this->table("zt_shsj_qd")->where(['openid'=>$openId,'date'=>date('Y-m-d',time())])->select()){
            return false;
        }
        $res = Db::table("zt_shsj_qd")->insert([
            "openid"=>$openId,
            'name'=>$res['name'],
            "teamid"=>$res['teamid'],
            "date"=>date('Y-m-d',time()),
            "time"=>date('H:i:s',time()),
            "address"=>$place,
            "in_place"=>$in_place?1:0
        ]);
        return $res;
    }


    /*
     *判断当日某人是否已经签到
     */
    public function isSignToday($openid){
        $date = date('Y-m-d',time());
        if($this->table('zt_shsj_qd')->where(['openid'=>$openid,'date'=>$date])->select()){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 重新签到
     */
    public function reSign($openid){
        return $this->table('zt_shsj_qd')->where(['openid'=>$openid,'date'=>date('Y-m-d',time())])->delete();
    }

    /**
     * 某天某任务的最新打卡情况
     */
    public function getDaily(){

    }

    /**
     * 某个时间段某个任务所有成员的签到情况统计
     */
    public function getAll($openid){
        $isCaptain = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['out_mark'];
        $teamid = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['teamid'];
        $allMember = $this->table("zt_shsj_user")->where(['teamid'=>$teamid])->select();
        $allSign = $this->table("zt_shsj_qd")->where(['teamid'=>$teamid,'date'=>date('Y-m-d',time())])->select();
        $a = array();
        $b = array();
        foreach($allSign as $key => $value){
            array_push($a,['name'=>$value['name'],'place'=>$value['address'],'isSign'=>true]);
            array_push($b,$value['name']);
        }
//        return json_encode($a);
        foreach ($allMember as $key => $value){
//            return  $value['name'];
            if(!in_array($value['name'],$b)){
                array_push($a,['name'=>$value['name'],'place'=>"今日未签到",'isSign'=>false]);
            }
        }
        $data['details'] = $a;
        $data['isCaptain'] = $isCaptain;
        return json_encode($data);
    }

    /**
     * 某个时间段某个任务某个成员的签到情况统计
     */
    public function getSimple(){

    }

    /**
     * 某个时间段某个任务某个成员的迟到情况统计
     */
    public function getLate(){

    }

    /**
     *  某个时间段某个任务某个成员的请假情况统计
     */
    public function getLeave(){

    }

    /**
     * 某个时间段某个任务某个成员的按时签到的情况统计
     */
    public function getOntime(){

    }

    /**
     *  某个时间段某个任务某个成员未签到的情况统计
     */
    public function getAbsent(){

    }
}