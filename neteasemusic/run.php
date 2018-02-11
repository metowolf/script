<?php
/**
 * @version 0.2.1
 * @author https://i-meto.com/
 */

require 'meting.php';
use Metowolf\Meting;

$stdin = fopen('php://stdin', 'r');

printf("请输入网易云音乐歌单编号: ");
$str = fread($stdin, 1000);
$id = $str;

printf("请输入您的网易云音乐 cookie [可选]: ");
$str = fread($stdin, 10000);
$cookie = $str;

$api = new Meting('netease');
if(!empty(trim($cookie))){
    $api->cookie(trim($cookie));
}
else $api->cookie('os=pc; osver=Microsoft-Windows-10-Professional-build-10586-64bit; appver=2.0.3.131777; channel=netease; __remember_me=true');

$data = $api->playlist($id);
$data = json_decode($data, true);
$jobs = array();
foreach($data['privileges'] as $key=>$vo){
    if($vo['st']!=0) {
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

$api = new Meting();
foreach($jobs as $index=>$job){
    printf("\n正在点亮第 %d 首歌曲《%s》- %s/%s\n",$index+1,$job['name'],$job['artist'],$job['album']);
    $best = 0;
    foreach(array('tencent', 'xiami', 'kugou', 'baidu') as $server) {
        printf(" + check " . $server . "\n");
        $api->site($server);
        $data = $api->format(true)->search($job['name'].' '.$job['artist']);
        $data = json_decode($data, true);
        foreach($data as $vo){
            $ta = $job['name'];
            $tb = $vo['name'];
            similar_text($ta,$tb,$per);
            if($per < 60)continue;
            $ta = $job['name'].$job['album'].$job['artist'];
            $tb = $vo['name'].$vo['album'].$vo['artist'][0];
            similar_text($ta,$tb,$per);
            if ($per > $best) {
                $url = $api->url($vo['url_id'], 320);
                $url = json_decode($url, true);
                if (!empty($url['url'])) {
                    $best = $per;
                    $ans = $vo;
                    printf(" + + 匹配到《%s》- %s/%s，相似度 %d%%\n", $ans['name'], $ans['artist'][0], $ans['album'], $best);
                }
            }
        }
    }
    $api->site($ans['source']);
    $url = $api->url($ans['url_id'], 320);
    $url = json_decode($url, true);
    exec(sprintf("curl -o \"download/%s - %s.mp3\" \"%s\"", $ans['name'], implode(',', $ans['artist']), $url['url']));

    sleep(2);
}
