# cookie管理组件

使用Jwt加密cookie数据提高网站安全

# 开始使用

#### 安装
使用 composer 命令进行安装或下载源代码使用。

```
composer require letnn/cookie
```

#### 配置 不设置则使用默认
```php
\letnn\Cookie::config([
    // cookie 保存时间
    'expire'   => 0,
    // cookie 保存路径
    'path'     => '/',
    // cookie 有效域名
    'domain'   => '',
    //  cookie 启用安全传输
    'secure'   => true,
    //  cookie 安全传输密钥
    'secure_key' => 'LangShen',
    //  cookie 前缀
    'prefix' => 'letphp##'
]);
```

#### 调用示例
```php
use letnn\Cookie;

// 设置
Cookie::set("app", "LangShen", 3600, "/", "qq.com");

// 检测
print Cookie::has("app") ? "存在" : "不存在";

// 获取
print Cookie::get("app");

// 全部
print Cookie::all();

// 删除
Cookie::delete("app");

// 清空
Cookie::flush();

```
