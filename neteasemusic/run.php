<?php
require 'meting.php';
use Metowolf\Meting;

$id = 14721111;
$cookie = '';

$api = new Meting('netease');
if(!empty($cookie))$api->cookie($cookie);
$data = $api->playlist($id);
$data = json_decode($data,true);
$jobs = array();
foreach($data['privileges'] as $key=>$vo){
    if($vo['st']!=0){
        $tmp = $data['playlist']['tracks'][$key];
        $jobs[]=array(
            'id'        => $tmp['id'],
            'name'      => $tmp['name'],
            'artist'    => $tmp['ar'][0]['name'],
            'album'     => $tmp['al']['name'],
        );
    }
}

printf("啊，找到 %d 首灰色歌曲呢\n",count($jobs));

$api = new Meting('tencent');
foreach($jobs as $index=>$job){
    printf("\n正在点亮第 %d 首歌曲《%s》- %s/%s\n",$index+1,$job['name'],$job['artist'],$job['album']);
    $data = $api->format(true)->search($job['name'].' '.$job['artist']);
    $data = json_decode($data,true);
    $best = 0;
    foreach($data as $vo){
        $ta = $job['name'];
        $tb = $vo['name'];
        similar_text($ta,$tb,$per);
        if($per < 50)continue;
        $ta = $job['name'].$job['album'].$job['artist'];
        $tb = $vo['name'].$vo['album'].$vo['artist'][0];
        similar_text($ta,$tb,$per);
        if($per > $best){
            $best = $per;
            $ans = $vo;
        }
    }
    printf("匹配到《%s》- %s/%s，相似度 %d%%\n",$ans['name'],$ans['artist'][0],$ans['album'],$best);

    $url = $api->url($ans['url_id']);
    $url = json_decode($url,true);
    exec('curl -o download/'.$ans['id'].'.mp3 "'.$url['url'].'"');

    sleep(2);
}
