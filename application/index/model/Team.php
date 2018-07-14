<?php
/**
 * Created by PhpStorm.
 * User: USER9
 * Date: 2018/6/17
 * Time: 5:15
 */

namespace app\index\model;

use think\db;
use think\Exception;
use think\Model;

class team extends Model
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
      $data['msg'] = '';
      $teamid = substr($val['code'],0,5);
      $id = substr($val['code'],5);
      if(!$record = $this->table('zt_shsj_user')->where(['phone'=>$val['phone']])->field('teamid,studentid,name')->select()){
          $data['msg'] = '手机号输入有误！';
      }
      else if($teamid!=$record[0]['teamid']||$id!=$record[0]['studentid']){
          $data['msg'] = '绑定码有误！';
      }else if($val['stuName']!=$record[0]['name']){
          $data['msg'] = '姓名有误！';
      }
//      elseif($this->table('zt_shsj_user')->where(['openid'=>$val['openid']])->select()){
//          $data['message'] = '你已经加入队伍或其他队伍';
//      }
      else if($this->table('zt_shsj_user')->where(['phone'=>$val['phone']])->select()[0]['openid']){
          $data['msg'] = '此队员已经被绑定';
      }
      else{
          $data['msg'] = '加入成功';
          $data['status'] = true;
          //成功则查询该队伍信息，和可能存在的其他插入操作
//          return $this->table('zt_shsj_team')->where(['bindcode'=>$val['code']])->select()[0]['teamid'];
//          $this->table('zt_shsj_user')->where(['openid'=>$val['openid']])->select();
//
//          $data['isCaptain'] = 'sql....';
//          $teamid = $this->table('zt_shsj_team')->where(['bindcode'=>$val['code']])->select()[0]['teamid'];

              $this->table('zt_shsj_user')->where(['phone'=>$val['phone']])->update(['openid'=>$val['openid'],'hasbind'=>1]);

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


  public function addUser($val){
      $data['status'] =false;
      $data['msg'] ='';

      $name = $val['name'];
      $phone = $val['phone'];
      $id = $val['id'];
      $index = $val['index']?0:1;
      $code = 'abccc';

      $teamid = $this->table('zt_shsj_user')->where(['openid'=>$val['openid']])->select()[0]['teamid'];

      if($this->table('zt_shsj_user')->where(['studentid'=>$id])->select()){
          $data['msg'] ='该成员已添加！';
      }else{
          if($this->table('zt_shsj_user')->insert(['teamid'=>$teamid,'name'=>$name,'studentid'=>$id,'phone'=>$phone,'ifout'=>$index,'bindcode'=>$code,'out_mark'=>0,'cate'=>$val['cate']])){
              $data['status'] =true;
          }
      }
      return json_encode($data);
  }

  public function getInfo($val){
      $openid = $val['openid'];
      $teamid = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['teamid'];
      $details = $this->table('zt_shsj_team')->where(['teamid'=>$teamid])->select()[0];
      $details['stuName'] = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['name'];
      $details['stuPhone'] = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['phone'];
      $cateNum = $details['category'];
      $cateName = $this->table('zt_shsj_cate')->where(['categoryid'=>$cateNum])->select()[0]['category'];
      $details['categoryName'] = $cateName;
      return json_encode($details);
  }
  public function getAllInfo($val){
      $openid = $val['openid'];
      $teamid = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['teamid'];

          $all = $this->table('zt_shsj_user')->where(['teamid'=>$teamid])->select();
          return json_encode($all);
          foreach($all as $key => $value){
              if(isset($value['openid'])&&$value['openid']){
                  $data['details'][$key] = array('teamStuName'=>$value['name'],'ifUseCode'=>'已绑定');
//                array_push($out,json_encode(array($key => array('teamStuName'=>$value['name'],'ifUseCode'=>'已绑定'))));
              }else{
                  $data['details'][$key] = array('teamStuName'=>$value['name'],'ifUseCode'=>$value['teamid'].$value['studentid']);
//                array_push($out,json_encode(array($key => array('teamStuName'=>$value['name'],'ifUseCode'=>$value['teamid'].$value['studentid']))));
              }
          }

      return json_encode($data);
  }


  public function getBinding($val){
      $openid = $val['openid'];
      $isCaptain = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['out_mark'];
      $teamid = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['teamid'];
      if(!$isCaptain){
          $data['isCaptain'] = false;
      }else{
          $data['isCaptain'] = true;
          $all = $this->table('zt_shsj_user')->where(['teamid'=>$teamid])->select();
          $out = array();
          foreach($all as $key => $value){
              if(isset($value['openid'])&&$value['openid']){
                  $data['details'][$key] = array('teamStuName'=>$value['name'],'ifUseCode'=>'已绑定');
//                array_push($out,json_encode(array($key => array('teamStuName'=>$value['name'],'ifUseCode'=>'已绑定'))));
              }else{
                  $data['details'][$key] = array('teamStuName'=>$value['name'],'ifUseCode'=>$value['teamid'].$value['studentid']);
//                array_push($out,json_encode(array($key => array('teamStuName'=>$value['name'],'ifUseCode'=>$value['teamid'].$value['studentid']))));
              }
          }
      }
      return json_encode($data);
  }


  public function deleteMember($val){
      $out['status'] = true;
      try{
          $openid = $val['openid'];
          $teamid = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()[0]['teamid'];
          $this->table("zt_shsj_user")->where(['studentid'=>$val['studentid']])->delete();
      }catch (Exception $e){
          $out['status'] = false;
          $out['msg'] = '系统错误';
      }
      return json_encode($out);
  }
  public function submitProblem($val){
      $out['status'] = true;
      try{
          $data = [
              'openid' => $val['openid'],
              'title' => $val['caption'],
              'content' => $val['content'],
              'phone' => $val['phone'],
              'is_deal' => 0,
              'create_time' => date( date('y-m-d h:i:s',time()))
          ];
          $this->table('zt_shsj_problem')->insert($data);
      }catch (Exception $e){
          $out['status'] = false;
          $out['msg'] = '系统错误';
      }
      return json_encode($out);

  }

  public function getBindingInfo($val){
      $data['ifJump'] = false;
      $openid = $val['openid'];
      if($res = $this->table('zt_shsj_user')->where(['openid'=>$openid])->select()){
          $data['ifJump'] = true;
          if(!$res[0]['out_mark']){
              $data['jumpWhere'] = 'sign';
          }else{
              if(!$this->table('zt_shsj_team')->where(['teamid'=>$res[0]['teamid']])->select()[0]['place']){
                  $data['jumpWhere'] = 'bindPlace';
              }else{
                  $data['jumpWhere'] = 'sign';
              }
          }
      }
      return json_encode($data);
  }
}