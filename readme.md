## 关于 ChaChaX

ChaChaX 是一个 V2Ray 的 Web 面板，可以实现流量计费和统计功能。

ChaChaX 分为 Web 端和 Node 端，二者需配合使用，Web 端即为本项目，Node 端暂无开源计划。

## 安装 ChaChaX

#### 配置节点

> ChaChaX Node 端暂不开源，请自行根据 Web 端的 API 进行开发。

在节点上安装 ChaChaX Node 端并运行。

#### 开通微小店

去这里注册并开通小店：[https://h5.youzan.com/v2/index/wxdpc](https://h5.youzan.com/v2/index/wxdpc )

手机下载客户端开通，不是微商城！是微小店，免费的！

#### 注册有赞云

去这里注册个人开发者：[https://www.youzanyun.com](https://www.youzanyun.com)

然后创建自用型应用，填写应用名称，下一步，选择你上面开通的小店名称并完成授权绑定。

> 注意：这里绑定应用的时候是没有微小店选项的，填写完应用名称后下一步是店铺授权，就有你手机上创建的微小店名称可选的。

#### 下载代码

    git clone https://github.com/kotoyuuko/thanks.git /var/www/thanks

然后把 `nginx` 啥的配好，这里就不浪费文字说明了。

#### 建立数据库

使用 `mysql` 命令行工具或 `phpMyAdmin` 建好数据库用户和数据库。

#### 配置程序

把 `.env.example` 重命名为 `.env`，然后打开 `.env`，使用文本编辑工具打开并编辑配置

#### 安装程序

    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    php artisan cache:clear
    php artisan config:cache
    php artisan route:cache
    php artisan view:clear
    php artisan storage:link

#### 生成前端资源

先去装个 yarn，然后：

    yarn

#### 添加计划任务

    crontab -u www -e

添加下面的任务：

    * * * * * /usr/bin/php7.2 /var/www/chachax/artisan schedule:run >> /dev/null 2 > &1

#### 测试

> 后台默认用户名密码均为 `admin`。

然后自己测试一下，有问题请自行解决。

## License

[MIT license](https://opensource.org/licenses/MIT).
