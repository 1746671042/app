<?php

/**
 * 上传文件
 */
class upload extends common{
    
    /**
     * 上传录像
     */
    public function uploadVideo(){
        //获取相关的值
        if(!isset($_FILES["myfile"])){
            $this->show(100,"数据不完整", "");
        }
        $file = $_FILES["myfile"];
//        var_dump($file);
        if($file["error"] != 0  ){
            $this->show(100201, "视频上传失败", "");
        }
        
        //上传操作
        $name = $file["name"];
        $extpos = strrpos($name,'.');//返回字符串filename中'.'号最后一次出现的数字位置
        $ext = substr($name,$extpos);
        $newName = time().rand(1000,9999).$ext;
        
        $upload = "video/".$newName;
        
        if(move_uploaded_file($file["tmp_name"], $upload)){
            //截取第一帧为封面图
            //ffmpeg获取视频帧 -i 后面是输出 -y 是质量 -f 是输出格式  -t 时间  
           $output = time().rand(1000,9999).".jpg";
            $command ="ffmpeg -v 0 -y -i $upload -vframes 1 -ss 5 -vcodec mjpeg -f rawvideo -s 286x160 -aspect 16:9 $output";
            //执行命令
            shell_exec($command);
            
            
            $arr= array("url"=>"http://www.lele.com/php/app/home/video/".$newName,"imgUrl"=>"http://127.0.0.1/php/app/home/".$output);
            $this->show(200,"视频上传成功", $arr);
        }else{
            $this->show("100201", "视频上传失败1","");
        }
    }
}