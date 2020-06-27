## 网易云音乐刷等级API

<p align="center">
    <a href="https://github.com/ZainCheung"><img alt="Author" src="https://img.shields.io/badge/author-ZainCheung-blueviolet"/></a>
    <img alt="PHP" src="https://img.shields.io/badge/code-PHP-success"/>
    <img src="https://visitor-badge.glitch.me/badge?page_id=ZainCheung.netease-cloud-api"/>
</p>

这是一个能够提供网易云音乐每日听满300首歌曲的基于PHP语言的API项目，配合python全自动脚本项目使用更佳。全自动脚本项目：https://github.com/ZainCheung/netease-cloud

## 灵感来自

[Binaryify/NeteaseCloudMusicApi](https://github.com/Binaryify/NeteaseCloudMusicApi)

## 功能特性

1. 登录
2. 签到
3. 查询用户信息
4. 听完300首歌曲

## 安装部署

建议新手使用自动托管方式，可以完全不需要编程基础即可搭建api接口，推荐使用网站：[https://glitch.com/](https://glitch.com/)

1. fork本项目到你的仓库

2. 打开网站注册并登陆，新建项目，选择从GitHub导入，地址为本项目的git地址
3. 修改你的glitch项目名，例如：netease-test
4. 那么你的接口名为“项目名.glitch.com”：https://netease-test.glitch.me/
5. 访问你的接口看到欢迎页面即部署成功

使用这种方式部署网站接口，0成本且快速可用，且不用担心环境部署运维等问题，当然如果有条件用自己的服务器搭建也是可以的。

或者可以直接复制一份项目成为你的项目,打开 https://glitch.com/edit/#!/netease-cloud-api 选择右上角的 `Remix to Exit`，即可成为你自己的项目，你便可以对代码进行修改，自定义你的域名

## 接口文档

### 调用前须知

> 本项目不提供线上 demo，请不要轻易信任使用他人提供的公开服务，如果使用，填写密码时一定要自己加密MD5，以免发生安全问题，泄露自己的账号和密码。

> 为使用方便,降低门槛, 文档示例接口直接使用了 GET 请求,本项目同时支持 GET/POST 请按实际需求使用 

> 本项目仅供学习使用，请勿利用此项目从事商业行为

> API登陆接口只接收MD5加密后的密码，并且不会储存你的个人信息，原密码除了你自己谁也不知道

> 使用本项目不会影响你的听歌风格，刷的歌都来自你的每日推荐歌单。

### 登录

说明 : 登录有两个接口,建议使用`encodeURIComponent`对密码编码或者使用`POST`请求,避免某些特殊字符无法解析,如`#`(`#`在url中会被识别为hash,而不是query)

#### 1. 手机登录

**必选参数 :**
`uin`: 手机号码

`pwd`: 密码

**接口地址 :** `/?do=login`

**可选参数 :** `r`: 0至1的随机数，例如`0.20246864764818318`

**调用例子 :** `/?do=login&uin=xxx&pwd=yyy`

#### 2. 邮箱登录

**必选参数 :**

`uin`: 163 网易邮箱

`pwd`: 密码

**接口地址 :** `/?do=email`

**调用例子 :** `/?do=email&uin=xxx&pwd=yyy`

完成登录后 , 会在浏览器保存一个 Cookies 用作登录凭证 , 大部分 API 都需要用到这个 Cookies,请求会自动带上 Cookies

### 签到

说明：调用接口这个接口可以签到

**接口地址 :** `/?do=sign`

### 打卡听歌

说明：由于网易云官方问题，打卡听歌只刷了一部分，可以多请求几次，建议每次间隔30秒请求3次左右

**接口地址 :** `/?do=daka`

### 获取用户详情

说明 : 登陆后调用此接口 , 传入用户 id, 可以获取用户详情

**必选参数 :** `uid` : 用户 id

**接口地址 :** ``/?do=detail`

**调用例子 :** `/`/?do=detail&uid=32953014`

注意获取用户信息接口传入的时`uid`，而登陆接口传入的是`uin`，不要搞混淆

### 检查接口

说明：调用此接口可检查当前项目API是否可用，建议在调用接口前先调用此接口做个判断

**接口地址 :** `/?do=check`
