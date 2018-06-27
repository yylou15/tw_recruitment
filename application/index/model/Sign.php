<?php
/**
 * Created by PhpStorm.
 * User: KIRITO
 * Date: 2018/6/27
 * Time: 10:10
 */

namespace app\index\model;


class Sign
{
    public function sign($timeLong,$taskID,$openId,$longitude,$latitude){

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