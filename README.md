## 基于hyperf + vue的通用管理后台权限管理

### 运行环境要求

**直接参考 hyperf 官方文档的运行环境:https://hyperf.wiki/#/zh-cn/quick-start/install**

### 安装

**拉取项目**

```php
git clone https://github.com/falys/hyperf-admin-management.git
```

**初始化项目依赖**

```php
composer install
```

**配置env文件,不存在env文件的话复制一份.env.example文件为.env

```php
APP_NAME=admin

DB_DRIVER=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=xxx
DB_USERNAME=xxx
DB_PASSWORD=xxx
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
DB_PREFIX=

REDIS_HOST=localhost
REDIS_AUTH=(null)
REDIS_PORT=6379
REDIS_DB=0

JWT_SECRET=jwthyperf
JWT_TTL=7200
JWT_ALG=HS256

```

**项目根目录下运行迁移(根目录下放置了初始化数据文件)**

```php
php bin/hyperf.php migrate
```

**启动项目(根目录下运行)**

```php
php bin/hyperf.php start
```

### 前端项目

项目地址：https://github.com/falys/vue-manage

**初始化依赖**

```vue
npm install
```

**运行服务**

```vue
npm run serve
```

**打包**

```vue
npm run build:test //测试环境
npm run build   //生产环境
```

### 参考项目

|                                                              |                           |
| ------------------------------------------------------------ | ------------------------- |
| [vue-manage-system](https://github.com/PanJiaChen/vue-element-admin) | vue-manage-system后台管理 |
| [vue-element-admin](https://github.com/PanJiaChen/vue-element-admin) | vue后台管理               |

