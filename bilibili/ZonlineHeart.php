<?php
/**
 *  Author： METO
 *  Version: 0.2.0
 */
class bilibili{

	public $user=array(
		array(
			'cookie' => 'buvid2=420B908A-36D4-47E3-B5DE-FDD929B3219A39877infoc; sid=9l8537bm; purl_token=bilibili_1494080590; dssid=756m00ccf1eb7eb2f; dsess=BAh7CkkiD3Nlc3Npb25faWQGOgZFVEkiFTAwY2NmMWViN2ViMmY1ZTcGOwBG%0ASSIJY3NyZgY7AEZJIiUwMTJiZjE4MzIwMjg3YzQ3MmM4MzAzNjAyZmY3YTYy%0AYgY7AEZJIg10cmFja2luZwY7AEZ7B0kiFEhUVFBfVVNFUl9BR0VOVAY7AFRJ%0AIi1jZDdlOGQ4NDE2NGUxNTFlNzdkOWE5YjYzNTlhYzE5Zjg0NzA4ZDkxBjsA%0ARkkiGUhUVFBfQUNDRVBUX0xBTkdVQUdFBjsAVEkiLWNhNGFlZTBlODEyMTRh%0AZGRjNWZiMTI4NzdjZjllNWM4YjhiZWI3ZDYGOwBGSSIKY3RpbWUGOwBGbCsH%0APdwNWUkiCGNpcAY7AEYiEjEyNS4xMjYuMjguMTI%3D%0A--58f55633a66ae37a4f38aaf94b8baa6c8ed74ad0; buvid3=94F00C90-B710-40ED-AFDD-81D8A3B1578C18593infoc; UM_distinctid=15bde2473bc5b-0aa3ada975b875-1571466f-100200-15bde2473bdb1; fts=1494080583; pgv_pvi=4416436224; pgv_si=s8980446208; LIVE_BUVID=5fba4817c1f03e4e3eb86db327a671ab; LIVE_BUVID__ckMd5=194948998d516919; DedeUserID=6287343; DedeUserID__ckMd5=6a2f2be363bc8da6; SESSDATA=5427e6cd%2C1496672621%2C36332b53; bili_jct=a41a331abf6cd0a452af50f6fd0f9ba6; LIVE_LOGIN_DATA=60a56dba8b09be8fbc637f1f9649a7ce923e0efc; LIVE_LOGIN_DATA__ckMd5=00031d9a0232a236; user_face=http%3A%2F%2Fi2.hdslb.com%2Fbfs%2Fface%2F3891a6cb345bc4bac6244890769d2effcfd7a297.jpg; _dfcaptcha=9cfd67869ac390c6e6ae338660e8bcdf',
			'status' => 1,
		),
		array(
			'cookie' => '第二个用户cookie',
			'status' => 0, // 0 表示禁用
		),
        // 多用户以此类推
	);

	public function display(){
		header('Content-Type: text/txt; charset=UTF-8');
		echo "===============================\n";
		foreach($this->user as $result){
			if($result['status']){
				$data=$result['data'];
				$a=$data['data']['user_intimacy'];
		        $b=$data['data']['user_next_intimacy'];
		        $per=round($a/$b*100,2);
				if(!isset($result['cron']['data'][1]))$msg='OK';
				else $msg='@'.date('Y-m-d H:i:s',$result['cron']['data'][1]);

		        echo "name   : {$data['data']['uname']} \n";
		        echo "level  : {$data['data']['user_level']} \n";
		        echo "exp    : {$a}/{$b} [{$per}%]\n";
				echo "status : {$msg}\n";
		        echo "===============================\n";
			}
			else{
				echo "status : {$result['data']['msg']}\n";
		        echo "===============================\n";
			}
		}
	}

    public function cron(){
		$mh=curl_multi_init();
		foreach($this->user as $id=>$user){
			if($user['status']!=1)continue;
			$curl[$id]=$this->create('http://live.bilibili.com/User/userOnlineHeart',$user['cookie']);
			curl_multi_add_handle($mh,$curl[$id]);
		}
		do{
		    curl_multi_exec($mh,$running);
		    curl_multi_select($mh);
		}while($running>0);
		foreach($curl as $id=>$c){
			$result[$id]=curl_multi_getcontent($c);
			curl_multi_remove_handle($mh,$c);
		}
		curl_multi_close($mh);
		foreach($result as $id=>$vo){
			$vo=json_decode($vo,1);
			$this->user[$id]['cron']=$vo;
		}
    }

	public function check(){
		$mh=curl_multi_init();
		foreach($this->user as $id=>$user){
			if($user['status']!=1)continue;
			$curl[$id]=$this->create('http://live.bilibili.com/User/getUserInfo',$user['cookie']);
			curl_multi_add_handle($mh,$curl[$id]);
		}
		do{
		    curl_multi_exec($mh,$running);
		    curl_multi_select($mh);
		}while($running>0);
		foreach($curl as $id=>$c){
			$result[$id]=curl_multi_getcontent($c);
			curl_multi_remove_handle($mh,$c);
		}
		curl_multi_close($mh);
		foreach($result as $id=>$vo){
			$vo=json_decode($vo,1);
			if($vo['code']<0)$this->user[$id]['status']=0;
			$this->user[$id]['data']=$vo;
		}
	}

	private function create($url,$cookie){
		$curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_COOKIE,$cookie);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl,CURLOPT_REFERER,'http://live.bilibili.com/');
        curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5');
		return $curl;
	}
}

$API=new bilibili;
$API->check();
$API->cron();
$API->display();
