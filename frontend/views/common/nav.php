<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/28
 * Time: 14:41
 *
 */
?><div class="topnav">
		<div class="topnav_bd w1210 bc">
			<div class="topnav_left">

			</div>
			<div class="topnav_right fr">
				<ul>
					<li>您好，欢迎来<?=!Yii::$app->user->isGuest?Yii::$app->user->identity->username:""?>[<?php
                        $htmlGuest = <<<html
<a href="/user/login">登录</a>] [<a href="/user/reg">免费注册</a>
html;
                        $htmlLogin = <<<html
<a href="/user/logout">注销</a>
html;
                        //判断未登录
                        if (Yii::$app->user->isGuest) {
                            echo $htmlGuest;
                        } else {
                            echo $htmlLogin;
                        }
                        ?>]</li>
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>