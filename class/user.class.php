<?php
class user extends common{
    //登录
    public function login(){
        $username = parent::post("name","");
        $pwd = parent::post("pwd","");
        if(empty($username) || empty($pwd)){
            $this->show(100, "用户信息不完整", "");
        }
        $pwd = md5($pwd);
        $sql = "select * from user where username ='{$username}' and pwd ='{$pwd}'";
         
        $result = $this->link->query($sql);
        if($result !=null){
            $this->show(200, "用户登录成功", $result["id"]);          
        }else{
            $this->show(100101, "用户登录失败,请检查！", "");
        }
    }
    
    
    
    
    
    //注册
    public function register(){
        $username = $this->post("name","");
        $pwd = $this->post("pwd","");
        $nickname = $this->post("nickname","");
         if(empty($username) || empty($pwd) || empty($nickname)){
            $this->show(100, "用户信息不完整", "");
           
        }
        $sql = "select * from user where username = '{$username}'";
        if($this->link->query($sql) !=null){
            $this->show(100103,"用户名已存在","");
        }
        $pwd = md5($pwd);
        $sql = "insert into user (username,pwd,nickname,image) values ('{$username}','{$pwd}','{$nickname}','http://www.lele.com/php/app/app/images/logo.png')";
        $result = $this->link->add($sql);
        if($result){
            $this->show(200, "注册成功", $result);
        }else{
            $this->show(100102, "注册失败", "");
        }
    }
    
    //发表
    public function upshow(){
         $content = $this->post("content","");
         $image_url = $this->post("image_url","");
         $video_url = $this->post("video_url","");
         $uid =$this->post("uid","");
         $see = $this->post("see",1);
         $data = date('Y-m-d H:i:s');
         
          if(empty($content)){
            $this->show(100,"信息不完整","");
          }else if(empty($uid)){
            $this->show(300,"请先登录","");
          }else if(empty($image_url)||empty($video_url)){
              $this->show(500,"请选择视频","");
          }
          else{
              $sql = "select * from user where id={$uid}";
              $user = $this->link->query($sql);
              $username = $user["username"];
              $nickname = $user["nickname"];
              
              
              $sql = "insert into video (username,image_url,theme,promulgator,video_url,time,see,look)value('{$username}','{$image_url}','{$content}','{$nickname}','{$video_url}','{$data}','{$see}',200)";
              $result = $this->link->add($sql);
              if($result){
                  $this->show(200,"发表成功",$result);
              }else{
                  $this->show(100102,"发表失败","");
              }
          }
         
         
    }
   
    
    //获取头像信息
    public function logo(){
        $uid =$this->post("uid","");
        if($uid ==""){
            $this->show(300,"当前用户未登录","");
        }else{
            $sql = "select * from user where id={$uid}";
            $result = $this->link->query($sql);
            if($result){
                $this->show(200,"",$result);
            }else{
                $this->show(100102,"修改头像失败","");
            }
        }
    }
    //获取用户信息
//    public function getUserInfo(){
//        $id = $this->post("id",0);
//        $sql = "select * from user where id= '{$id}'";
//        $data = $this->link->query($sql);
//        $this->show(200, "获取成功", $data);
//    }
}