<?php
/**
 * Created by PhpStorm.
 * User: USER9
 * Date: 2018/6/17
 * Time: 5:15
 */

namespace app\index\model;


class team
{

    /*
     * 创建团队
     * @param  xxxx string 项目类别
     * @param  name string 负责人姓名
     * @param  老师姓名
     * @param   老师号码
     * @param   手机号
     */
  public function setupTeam($val){
        //1这里一条插入，成功则生成绑定码$code返回，否则不返回值
      if(1){
         return $this->make_code();
      }
  }


  /*
   * 生成队伍绑定码
   * @return string 绑定码
   */
  private function make_code(){
      $uid = uniqid ( "", true );
      $data = $_SERVER ['REQUEST_TIME']; 	// 请求那一刻的时间戳
      $hash = strtoupper ( hash ( 'ripemd128', $uid . md5 ( $data ) ) );
      return $hash;
  }

}