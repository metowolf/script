<?php
/**
 *  Author： METO
 *  Version: 0.1.0
 */

class bilibili{

    protected $_COOKIE='YOUR COOKIE';
    protected $_USERAGENT='Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.101 Safari/537.36';
    protected $_REFERER='http://live.bilibili.com/';

    private function getinfo(){
        $data=json_decode(self::curl('http://live.bilibili.com/User/getUserInfo'),1);
        $a=$data['data']['user_intimacy'];
        $b=$data['data']['user_next_intimacy'];
        $per=round($a/$b*100,2);
        echo "===============================\n";
        echo "name: {$data['data']['uname']} \n";
        echo "level: {$data['data']['user_level']} \n";
        echo "exp: {$a}/{$b} {$per}%\n";
        echo "sign: ".self::sign()."\n";
        echo "===============================\n";
    }

    private function sign(){
        $raw=json_decode(self::curl('http://live.bilibili.com/sign/doSign'),1);
        return $raw['msg'];
    }

    public function cron(){
        header('Content-Type: text/txt; charset=UTF-8');
        echo date('[Y-m-d H:i:s]',time())."\n";
        $raw=json_decode(self::curl('http://live.bilibili.com/User/userOnlineHeart'),1);
        if(!isset($raw['data'][1]))echo " > SUCCESS\n";
        else echo " > INFO: already send @ ".date('Y-m-d H:i:s',$raw['data'][1])."\n";

        self::getinfo();
    }

    protected function curl($url){
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl,CURLOPT_REFERER,$this->_REFERER);
        curl_setopt($curl,CURLOPT_COOKIE,$this->_COOKIE);
        curl_setopt($curl,CURLOPT_USERAGENT,$this->_USERAGENT);
        $result=curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}

(new bilibili)->cron();
