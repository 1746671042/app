<?php
class limit extends common{
   public function getVideo(){
       $page = $this->get("page",1);
       $num =10;
       $start = ($page-1)*$num;
       $sql = "select * from video where is_auditor = '3'";
       $result = $this->link->queryAll($sql);
       foreach($result as $rk=>$rv){
            $username = $rv["username"];
            $sql = "select * from user where username ={$username}";
            $results = $this->link->query($sql);
            $result[$rk]["user"]=$results;
       }
//       var_dump($result);
        $this->show(200, "", $result);
        
   }
   //关注列表
   public function followList(){
       $uid = parent::post("uid",0);
       $sql = "select * from follow where user_id ='{$uid}'";
       $result = $this->link->queryAll($sql);
       foreach($result as $k=>$v){
           $id = $v["video_user_id"];
           $sql = "select * from user where id = {$id}";
           $results = $this->link->query($sql);
           $result[$k]["user"]=$results;
       }
       if($result){
           $this->show(200,"",$result);
       }else{
           $this->show(500,"失败","");
       }
   }
   
   
   //关注
  public function guanZhu(){
       $uid = parent::post("uid",0);
       $followId = parent::post("followId",0);
       $sql = "insert into follow(video_user_id,user_id) values({$followId},{$uid})";
       if($this->link->add($sql)){
           $this->show(200, "关注成功", "");
       }else{
           $this->show(100, "关注失败", "");
       }
   }
   
     //取消关注
  public function removeZhu(){
       $uid = parent::post("uid",0);
       $videoId = parent::post("videoId",0);
       
       $sql = "delete from follow where user_id='{$uid}' and video_user_id='{$videoId}'";
       $result = $this->link->delete($sql);
//       var_dump($videoId);
       if($result){
           $this->show(200, "关注取消成功", "");
       }else{
           $this->show(100, "关注取消失败", "");
       }
   }
   
   //点赞
   public function fabulous(){
       $uid = parent::post("uid",0);
       $videoId = parent::post("videoId",0);
       $sql = "insert into fabulous(video_id,user_id) values({$videoId},{$uid})";
       if($this->link->add($sql)){
           $this->show(200, "赞成功", "");
       }else{
           $this->show(100, "赞失败", "");
       }
//       var_dump($this->link->add($sql));
   }
   
   //点赞
   public function collect(){
       $uid = parent::post("uid",0);
       $video_Id = parent::post("video_Id",0);
       $sql = "insert into collect(video_id,user_id) values({$video_Id},{$uid})";
       if($this->link->add($sql)){
           $this->show(200, "收藏成功", "");
       }else{
           $this->show(100, "收藏失败", "");
       }
//       var_dump($this->link->add($sql));
   }
   
   
   
    
};
