<?php
/**
 * Created by PhpStorm.
 * User: KIRITO
 * Date: 2018/6/27
 * Time: 10:10
 */

namespace app\index\model;
use think\Db;

class Sign
{
    public function checkTime($data,$taskID){
        $res = Db::table('zt_shsj_teamtask')->where(['taskid'=>$taskID])->select("taskid,starttime,endtime")[0];
        if($res==null){
            $data['message']="there is no such task";
        }
        else{
            $now=time();
            $start = strtotime($res['starttime']);
            $end = strtotime($res['endtime']);
            if($now<$start)
                $data['message']= "too early";
            elseif ($now<$end){
                $data['time']=date("Y-m-d H:i:s");
                $data["in_time"]="normal";
                $data['message']= "time success";
            } else{
                $data['in_time'] = "late";
                $data['message']= "you are late";
            }
        }
        return $data;
    }

    public function checkPlace($data,$taskID,$longitude,$latitude){
        $res = Db::table('zt_shsj_teamtask')->where(['taskid'=>$taskID])->select("taskid,lat,lng,address")[0];
        $lat=$res['lat'];
        $lng=$res['lng'];
        if($res==null) {
            $data['message']="there is no such task";
        } else{
            // check place
            if(1){
                $data['lng']=$longitude;
                $data['lat']=$latitude;
                $data['address']=$res['address'];
                $data['message']="place success";
            }else{
                $data['message']="wrong place";
            }
        }
        return $data;
    }

    public function submit($openId,$taskID,$data){
        $res = Db::table("zt_shsj_qd")->insert([
            "openid"=>$openId,
            "taskid"=>$taskID,
            "time"=>$data['time'],
            "address"=>$data['address'],
            "lat"=>$data['lat'],
            "lng"=>$data['lng'],
            "in_time"=>$data['in_time']
        ]);
        return $res;
    }
    /**
     * 某天某任务的最新打卡情况
     */
    public function getDaily(){

    }

    /**
     * 某个时间段某个任务所有成员的签到情况统计
     */
    public function getAll(){

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