# Download script for UVa Online Judge
[![][license img]][license]

UVa Online Judge 题目下载，批量拉取 PDF 题目。

## Function

 - [x] Multi-Thread using FIFO (bash-ver) (多线程)
 - [x] Errorlog (错误日志)
 - [x] Timing (下载计时)
 - [x] MultiPlatform

## Platform

 - [x] Windows (PowerShell-ver)
 - [x] WSL
 - [x] MinGW
 - [x] GNU/Linux
 - [x] MacOS
 - [x] BSDs

## Run


+ To run the bash script with a default number of 20 threads, do the following:

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
**Notice:** This bash script is incompatible with zsh.

+ To run the PowerShell script, do the following:

```
$ powershell -executionpolicy bypass -file UVadownload.ps1
```

## License

Download script for UVa Online Judge is available under the [MIT license](http://opensource.org/licenses/MIT).

```
MIT License

Copyright (c) 2016-2017 METO, Chijun Sima

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

[license]:LICENSE
[license img]:https://img.shields.io/github/license/mashape/apistatus.svg?style=flat-square