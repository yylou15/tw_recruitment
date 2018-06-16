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
     * @param  老师号码
     * @param  手机号
     */
  public function setupTeam($val){
        //1这里一条插入，成功则生成绑定码$code返回，否则不返回值
      if(1){
         return $this->make_code();
      }
  }
  /*
   * 负责人认证
   */
  public function checkCaptain($val){
      //待填......
      return 1;
  }
  /*
   * 加入队伍
   * @param  name string 姓名
   * @param  code string 绑定码
   * @return array
   */
  public function bindTeam($val){
      //一条查询一条插入
      $data['status'] = false;
      $data['message'] = '';
      if(!1/*这里写查询*/){
          $data['message'] = '队伍不存在';
      }elseif(!2/*这里写插入*/){
          $data['message'] = '你已经加入该队伍';
      }else{
          $data['message'] = '加入成功';
          $data['status'] = true;
          //成功则查询该队伍信息，和可能存在的其他插入操作
          $data['info'] = 'sql....';
      }
      return $data;
  }
  /*
   *问题反馈
   * @param  caption string 标题
   * @param  phone   string 联系方式
   * @param  detail  string 问题详细描述
   * @return bool
   */
  public function problemSubmit($val){
        //一条插入即可，成功返回true，否则返回false
      if(1){
          return true;
      }else{
          return false;
      }
  }


  /*
   * 生成队伍绑定码
   * @return string 绑定码
   */
  private function make_code(){
      $uid = uniqid ( "", true );
      $data = $_SERVER ['REQUEST_TIME']; 	// 请求时的时间戳
      $hash = strtoupper ( hash ( 'ripemd128', $uid . md5 ( $data ) ) );
      $hash = substr($hash,0,9);
      return $hash;
  }

}