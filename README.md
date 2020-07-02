## 网易云音乐升级API

<p align="center">
    <a href="https://github.com/ZainCheung"><img alt="Author" src="https://img.shields.io/badge/author-ZainCheung-blueviolet"/></a>
    <img alt="PHP" src="https://img.shields.io/badge/code-PHP-success"/>
    <img src="https://visitor-badge.glitch.me/badge?page_id=ZainCheung.netease-cloud-api"/>
</p>
这是一个通过调用官方接口，能够提供网易云音乐每日听满300首歌曲的基于PHP语言的API项目。

强烈建议配合python全自动脚本项目使用更佳：https://github.com/ZainCheung/netease-cloud

## 灵感来自

[Binaryify/NeteaseCloudMusicApi](https://github.com/Binaryify/NeteaseCloudMusicApi)

## 功能特性

1. 登录
2. 签到
3. 查询用户信息
4. 听完300首歌曲

## 安装部署

建议新手使用自动托管方式，可以完全不需要编程基础即可搭建api接口，推荐使用网站：[https://glitch.com/](https://glitch.com/)

这个网站是国外的，名气也很大，在上面托管网站的有几百万，免费使用，缺点就是速度没有国内的服务器快，还有就是如果没有访问了，一定时间后会进入休眠，等待下一次请求到来后需要等待几秒的解冻时间。不过这些对这个项目并没有什么影响，所以可以放心部署。

下面三种方法，第一种第二种最简单但速度慢，而且需要你有网站账号，第三种访问速度快但需要你有服务器，大家自己取舍，但基本上有服务器了都想自己搭建吧，大家随意

## 方法一 导入GitHub

1. fork这个API项目到你的仓库

2. 打开网站注册并登陆，新建项目，选择从GitHub导入，地址为本项目的git地址
3. 修改你的glitch项目名，例如：netease-test
4. 那么你的接口名为“项目名.glitch.com”：https://netease-test.glitch.me/
5. 访问你的接口看到欢迎页面即部署成功

使用这种方式部署网站接口，0成本且快速可用，且不用担心环境部署运维等问题，当然如果有条件用自己的服务器搭建也是可以的。

#### 1. fork项目

![](https://s1.ax1x.com/2020/06/29/NWoCGj.png)

#### 2. 导入项目

##### 2-1. 填入你的的git地址,地址在你的Github项目的clone按钮里,要用https

![](https://s1.ax1x.com/2020/06/29/NWo8L6.png)

##### 2-2. 改自己项目名

![](https://s1.ax1x.com/2020/06/29/NWocTS.png)

##### 2-3. 获得API地址

![](https://s1.ax1x.com/2020/07/02/Nb1c1e.png)

##### 又或者

![](https://s1.ax1x.com/2020/07/02/Nb1WnA.png)

## 方法二 直接复制项目

或者可以直接复制一份这个API项目成为你的项目,进入开发者的api服务器： https://glitch.com/edit/#!/netease-cloud-api 选择右上角的 `Remix to Exit`，即可成为你自己的项目，你便可以对代码进行修改，自定义你的域名。

![](https://s1.ax1x.com/2020/06/29/NWTJcn.png)

##### 获得API地址

![](https://s1.ax1x.com/2020/07/02/Nb1c1e.png)

##### 又或者

![](https://s1.ax1x.com/2020/07/02/Nb1WnA.png)

## 方法三 服务器部署

部署到服务器，对于新手还是比较建议安装宝塔面板，然后就可以在浏览器中进行界面化操作，免得有的人不会Linux的命令行。

#### 1. 下载PHP

确保下载了PHP,版本不要太老就行

![](https://s1.ax1x.com/2020/06/29/NWh7Ps.png)

#### 2. 添加网站

填入你提前在你的域名运营商解析的域名，可以是子域名比如，api.xxxxxx.com，写个网站备注，然后根目录选择到下载的项目路径，FTP不创建，数据库不创建默认utf-8就行，程序类型PHP，版本选择下载的版本，提交即可运行你的网站.

![](https://s1.ax1x.com/2020/06/29/NWhza4.png)

![](https://s1.ax1x.com/2020/06/29/NW4Ydg.png)

#### 运行网站

这里演示域名为test.com,然后在浏览器里输入你的网站地址，看到欢迎页面即为部署成功

![](https://s1.ax1x.com/2020/06/29/NW4hS1.png)

![](https://s1.ax1x.com/2020/06/29/NWIt8s.png)

## 接口文档

https://github.com/ZainCheung/netease-cloud-api/wiki

## 声明

本项目的所有脚本以及软件仅用于个人学习开发测试，所有`网易云`相关字样版权属于网易公司，勿用于商业及非法用途，如产生法律纠纷与本人无关。
