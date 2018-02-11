# 妈妈再也不用担心我的网易云音乐变灰了

批量从其它渠道下载网易云音乐下架的歌曲。~~以便后续传到网易云音乐云盘上~~

## 使用指南

下载本目录下的所有文件，直接执行 `php run.php`，没错就是这么简单。

下载完成后可以在 `download` 文件夹下找到所有歌曲文件，自由发挥

注意这是在终端执行，那些扔到 PHP 虚拟主机后直接访问网页的不要来问我为什么不能用好吗～

## 环境要求
 - PHP
 - cURL

## 效果
```
$ php run.php
请输入网易云音乐歌单编号: 14721111
请输入您的网易云音乐 cookie [可选]:
啊，找到 21 首灰色歌曲呢

正在点亮第 1 首歌曲《火锅底料》- GAI爷/火锅底料
 + check tencent
 + + 匹配到《火锅底料》- GAI/火锅底料，相似度 94%
 + check xiami
 + check kugou
 + check baidu
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100 7375k  100 7375k    0     0  2112k      0  0:00:03  0:00:03 --:--:-- 2112k

正在点亮第 2 首歌曲《孤儿仔》- 陈奕迅/Eason 4 A Change & Hits
 + check tencent
 + + 匹配到《孤儿仔》- 陈奕迅/Eason 4 A Chance & Hits，相似度 97%
 + check xiami
 + + 匹配到《孤儿仔》- 陈奕迅/Eason 4 A Change & Hits，相似度 100%
 + check kugou
 + check baidu
  % Total    % Received % Xferd  Average Speed   Time    Time     Time  Current
                                 Dload  Upload   Total   Spent    Left  Speed
100 3475k  100 3475k    0     0  1601k      0  0:00:02  0:00:02 --:--:-- 1602k

...
```
