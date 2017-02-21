# Download script for UVa Online Judge

UVa Online Judge 题目下载，批量拉取 PDF 题目。

## Function

 - [x] Multi-Thread using FIFO (多线程)
 - [x] Errorlog (错误日志)
 - [x] Timing (下载计时)
 - [x] MultiPlatform

## Platform

 - [x] WSL
 - [x] MinGW
 - [x] GNU/Linux
 - [x] MacOS
 - [x] BSDs

## Run

To run the script with a default number of 20 threads, do the following:

```
$ bash download.sh
```
To run the script with a customized number of threads, do the following:

```
$ bash download.sh "threads" (without quotes)
```
e.g.
```
$ bash download.sh 20
```
