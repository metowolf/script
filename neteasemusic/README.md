# 妈妈再也不用担心我的网易云音乐变灰了

批量从其它渠道下载网易云音乐下架的歌曲。~~以便后续传到网易云音乐云盘上~~

## 使用指南

下载本目录下的所有文件，然后修改 `run.php` 中的两项配置：
```
$id = 14721111; //想要操作的歌单编号
$cookie = ''; // 填入网易云音乐的 cookie 以便更精准判断是否变灰
```

执行 `php run.php`，没错就是这么简单。

注意这是在终端执行，那些扔到 PHP 虚拟主机后直接访问网页的不要来问我为什么不能用好吗～

## 环境要求
 - PHP
 - cURL

## 效果
```
$ php run.php
找到 22 首灰色歌曲呢

正在点亮第 1 首歌曲《回忆那么伤 》- 孙子涵/双子涵
匹配到《回忆那么伤》- 孙子涵/回忆那么伤，相似度 71%
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100 9239k  100 9239k    0     0  2720k      0  0:00:03  0:00:03 --:--:-- 2720k

正在点亮第 2 首歌曲《孤儿仔》- 陈奕迅/Eason 4 A Change & Hits
匹配到《孤儿仔》- 陈奕迅/Eason 4 A Chance & Hits，相似度 97%
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100 8715k  100 8715k    0     0  2653k      0  0:00:03  0:00:03 --:--:-- 2653k

...
```
