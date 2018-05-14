# yii商场的总结
## 品牌的管理
### 1:先分析出品牌的的字段；
### 2:草拟一张分析图；
#### 3:由易到难 先把熟悉的增删改查（CURD）
### 4: 架子搭好后在慢慢添加功能
# 文章的分类管理，文章的分类，读取文章的内容
## 问题如下：
### 1：表与表之间的关系有点乱
### 2：图片的上传不够熟悉
### 3：思维不够灵活，全是墨守成规 更到起敲得。
## 问题解决办法：
### 1；加大练习强度
### 2：多想想，多看看，多练练。
### 分页：
            $page= new Pagination([
            'pageSize' => 2, //每页显示条数
            'totalCount' => $conunt,  //总条数
        ]);
        
        //查数据
        $model=$query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',compact('model','page'));
#         商品的管理：
## 1：先分析出品牌的的字段，创建表
## 2：实现无限极分类：
### 安装组件：composer require creocoder/yii2-nested-sets
### 3：安装组件：composer require liyuze/yii2-ztree 
### 4:composer require leandrogehlen/yii2-treegrid 实现CURD
# 登录管理
#### 1：最后登录IP代码-> $_SERVER['REMOTE_ADDR']
####  2：分析字段。
## 3：设计场景
## 第一步
            public  function scenarios()
           {
              $fuck= parent::scenarios(); //默认场景
               $fuck['add']=['username','password'];
               $fuck['edit']=['username','password'];
               return $fuck;
        
           }
## 第二步 设计规则
     public function rules()
        {
            return [
               [['username'],'required'],
                [['password','status'],'safe','on'=>'edit'],
                [['password'],'required','on'=>'add'],
                [['username'], 'unique'],
            ];
        }
##     第三步 设置 edit场景
     $models->setScenario('edit');
     
###      赋值
          $password=$models->password;
###      三元判断
      $models->password=$models->password?\Yii::$app->security->generatePasswordHash($models->password):$password;

## 需求
1.	管理员增删改查
2.	管理员登录和注销
3.	自动登录(基于cookie)
4.	促销管理(选做)
###  要点
1.	创建admin表(在user表基础上添加最后登录时间和最后登录ip


# 	项目描述简介
#### 类似京东商城的B2C商城 (C2C B2B O2O P2P ERP进销存 CRM客户关系管理)电商或电商类型的服务在目前来看依旧是非常常用，虽然纯电商的创业已经不太容易，但是各个公司都有变现的需要，所以在自身应用中嵌入电商功能是非常普遍的做法为了让大家掌握企业开发特点，以及解决问题的能力，我们开发一个电商项目，项目会涉及非常有代表性的功能。为了让大家掌握公司协同开发要点，我们使用git管理代码。在项目中会使用很多前面的知识，比如架构、维护等等。

# 	主要功能模块
## 系统包括：
### 后台：品牌管理、商品分类管理、商品管理、订单管理、系统管理和会员管理六个功能模块。
### 前台：首页、商品展示、商品购买、订单管理、在线支付等。
# 	开发环境和技术

开发环境  | Window 
---|---
开发工具 | Phpstorm+PHP7.1+GIT+Apache
相关技术 | Yii2.0+CDN+jQuery+sphinx
# 	需求
- [x]   品牌管理：
- [x]   商品分类管理：
- [x]   商品管理：
- [x]   账号管理：
- [ ]   权限管理：
- [ ]   菜单管理：
- [ ]   订单管理：

# 	设计要点（数据库和页面交互）
##### 系统前后台设计：前台www.yiishop.com 后台admin.yiishop.com 对url地址美化
##### 商品无限级分类设计：
##### 购物车设计
# 	要点难点及解决方案：
##### 难点在于需要掌握实际工作中，如何分析思考业务功能，如何在已有知识积累的前提下搜索并解决实际问题，抓大放小，融会贯通，尤其要排除畏难情绪。




123