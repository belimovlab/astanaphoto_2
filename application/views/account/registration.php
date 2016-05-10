<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo $header;
?>

<div class="container_15 margin_top_20px">
    <div class="grid_11">
        <div class="panel">
            <div class="panel_title"><?php echo $title;?></div>
            <div class="panel_content">
                <?php if($error):?>
                <p class="error_mess">
                    <?php echo $error;?>
                </p>
                <?php endif;?>
                <?php if($success):?>
                <p class="success_mess">
                    <?php echo $success;?>
                </p>
                <?php endif;?>
                <form action="<?php echo base_url('/account/try_registration')?>" method="POST">
                <div class="sub_content_block">
                    <div class="sub_title">1. Вид профиля</div>
                    <div class="sub_content_block_content">
                        <p>
                            <label for="email">Род занятий</label>
                        </p>

                        <p>
                            <select name="account" id="account" required>
                                <option value="-1">Я хочу воспользоваться услугами исполнителя ( Пользователь )</option>
                                <?php foreach($ganres as $one):?>
                                <option value="<?php echo $one->id?>" <?php echo  $account == $one->id ? 'selected' : ''?>><?php echo $one->name?></option>
                                <?php endforeach;?>
                            </select>
                        </p>
                        <p class="color_777 font_size_11px">
                            Если вы не хотите оказывать услуги, а просто хотите найти нужных вам исполнителей, сохранить их в своих контактах и оставлять отзывы о них, выбирайте пункт  - <strong>Я хочу воспользоваться услугами исполнителя ( Пользователь )</strong>
                        </p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="sub_content_block">
                    <div class="sub_title">2. Регистрационные данные</div>
                    <div class="sub_content_block_content">
                        <p>
                            <label for="email">Email</label>
                        </p>
                        <p>
                            <input type="email" required name="email" id="email" placeholder="Email..." value="<?php echo $email ? $email : ''?>"/>
                        </p>
                        <p>
                            <label for="password">Пароль</label>
                        </p>
                        <p>
                            <input type="password" required name="password" id="password" placeholder="Пароль..." value="<?php echo $password ? $password : ''?>"/>
                        </p>
                        <p>
                            <label for="re_password">Подтверждение пароля</label>
                        </p>
                        <p>
                            <input type="password" required name="re_password" id="re_password" placeholder="Подтверждение пароля..." value="<?php echo $re_password ? $re_password : ''?>"/>
                        </p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="sub_content_block">
                    <div class="sub_title">3. Личные данные</div>
                    <div class="sub_content_block_content">
                        <p>
                            <label for="first_name">Имя</label>
                        </p>
                        <p>
                            <input type="text" required name="first_name" id="first_name" placeholder="Имя" value="<?php echo $first_name ? $first_name : ''?>"/>
                        </p>
                        <p>
                            <label for="second_name">Фамилия</label>
                        </p>
                        <p>
                            <input type="text" name="second_name" required id="second_name" placeholder="Фамилия" value="<?php echo $second_name ? $second_name : ''?>"/>
                        </p>
                        <p>
                            <label for="birthday">Дата рождения</label>
                        </p>
                        <p>
                            <input type="date" required name="birthday" id="birthday" placeholder="" value="<?php echo $birthday ? $birthday : ''?>"/>
                        </p>
                        <p>
                            <label for="sex">Пол</label>
                        </p>
                        <p>
                            <select name="sex" id="sex" required="">
                                <option value="male" <?php echo $sex == 'male' ? 'selected' : ''?>>Мужской</option>
                                <option value="female" <?php echo $sex == 'female' ? 'selected' : ''?>>Женский</option>
                            </select>
                        </p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <p class="text_align_center margin_top_20px">
                    <button class="btn btn_blue" type="submit"><i class="fa fa-check"></i> Я принимаю условия использования и регистрируюсь в сервисе</button>
                </p>
                </form>
            </div>
            <a class="show_all_button" href="<?php echo base_url('/account/login');?>">У меня уже есть аккаунт. Войти</a>
        </div>
    </div>
    <div class="grid_4">
        <div class="panel">
            <div class="panel_title">Информация о регистрации</div>
            <div class="panel_content">
                <div class="reg_advantage">
                    <ul>
                        <li><strong>Род занятий</strong>  - это вид вашего аккаунта. В зависимости от выбранного вида аккаунта, вам будут доступны функции сервиса только для вашего вида аккаунта.</li>
                        <li><strong>Email</strong> служит логином и идентификатором пользователя. На указанный Email будут отправляться уведомления с сервиса.</li>
                        <li><strong>Имя и фамилия</strong> позволит вашим клиентам найти вас быстрее в поиске.</li>
                        <li><strong>Подтверждение</strong> Email необходимо для дальнейшей работы в сервисе.</li>
                        <li><strong>Обязательным</strong> условием использования сервиса является абсолютное и полное согласие с <a href="<?php echo base_url('/terms')?>" class="right_terms">условиями использования сервиса.</a></li>
                    </ul>
                </div>
                <p class="btn_more">
                    <a href="<?php echo base_url('/account/registration');?>">Зарегистрироваться</a>
                </p>
            </div>
        </div>
    </div>
</div>


<?php echo $footer;