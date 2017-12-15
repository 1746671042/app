<?php
class info extends common{
    //内容
    public function content(){
        $video_id = parent::post("video_id",1);
        $user_id = parent::post("uid",1);
        $sql = "select * from video where id={$video_id}";
        $result = $this->link->queryAll($sql);
        $result = $result[0];
//          $videoId = $v["id"];
            $sqls = "select * from comment where video_id={$video_id}";
            $results = $this->link->queryAll($sqls);
            foreach($results as $sc=>$zc){
                $userid = $zc["id"];
                $sqlss = "select * from user where id={$userid}";
                $ret = $this->link->query($sqlss);
                $results[$sc]["user"]=$ret;
            }

        $data = array("info"=>$result,"comment"=>$results);
        if($data){
            $this->show(200,"",$data);
        }else{
            $this->show(100,"数据调取失败","");
        }
        
       
    }
    
    
    public function comment(){
        $video_id = parent::post("video_id",1);
        $uid = parent::post("uid",1);
        $content = parent::post("content","");
        $time = date('Y-m-d h:m:s');
      
        $sql = "insert into comment (user_id,video_id,add_time,content) values({$uid},{$video_id},'{$time}','{$content}')";
        $result = $this->link->add($sql);
        if($result){
            $this->show(200,"评论成功",$result);
        }else{
            $this->show(100,"评论失败","");
        }
    }
};