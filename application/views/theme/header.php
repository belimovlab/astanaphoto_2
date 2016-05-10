<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo $title?></title>
    <meta name="viewport" content="width=1200px">
    <link rel="icon" href="/assets/images/favicon_1.ico" type="image/x-icon"/>
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="/assets/css/common/normalize.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/common/grid.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/common/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/common/common.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/common/toast.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/common/imagehover.min.css" rel="stylesheet" type="text/css"/>
    
    <?php foreach($css as $one):?>    
        <?php if($one):?>
            <link href="/assets/css/<?php echo $one;?>.css" rel="stylesheet" type="text/css"/>
        <?php endif;?>
    <?php endforeach;?>
            
    <script src="/assets/js/jquery-2.1.3.min.js"></script>
    <script src="/assets/js/toast.js"></script>
    <script src="/assets/js/main_app.js"></script>
</head>
<body>
    <header>
        <div class="container_15">
            <div class="grid_3 logo">
                <a href=""><img src="/assets/images/logo_new_2.png"></a>
            </div>
            <div class="grid_6 navigation">
                <a href="<?php echo base_url('/doer')?>">Исполнители</a>
                <a href="<?php echo base_url('/actions')?>">Акции</a>
                <a href="<?php echo base_url('/contest')?>">Конкурсы</a>
                <a href="<?php echo base_url('/news')?>">Статьи</a>
            </div>
            <div class="grid_6 login_area">
                <div class="login_area_user">
                    <?php if($user_info->user_id):?>
                    <div class="user_name">
                        <a href="<?php echo base_url('/profile')?>"><img src="/content/user_avatars/small_1459685004_f75411d2ff3c23e2a41cd1062caa13b1.jpg"></a>
                        <a href="<?php echo base_url('/profile')?>"><?php echo $user_info->first_name." ".$user_info->second_name?></a>
                    </div>
                    <div class="logout">
                        <a href="<?php echo base_url('/account/logout')?>" class="btn btn_red">Выйти</a>
                    </div>
                    <?php else:?>
                    <div class="logout">
                        <a href="<?php echo base_url('/account/login')?>" class="btn btn_blue">Войти</a>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </header>