<?php
    
    class MainSiteConfig{
        private static $outer_config = array(
            'site_url'              => 'http://astana.cms/',          // URL Сайта
            'site_panel_url'        => 'http://astana.cms/panel/',    // URL панели администратора
            'site_title'            => 'АстанаФото',                      // Название сайта(Будет выводиться если не задано для страницы)
            'site_set_session_path' => './cache_sess',                     // Путь к папке с сессиями
            'encryption_key'        => 'Super_secret_key_5203',            // Ключ Шифрования на сайте данных
            'db_host'               => 'localhost',                        // Сервер базы данных
            'db_user'               => 'root',                             // пользователь БД
            'db_password'           => 'pass',                             // Пароль  БД
            'db_name'               => 'astanaphoto.cms',                  // Название БД
            'noreply_email'         => 'noreply@astanaphoto.pro',          // Email  для отправдения писем
            'email_from_name'       => 'Администрация сервиса',            // Имя для Email
            'not_avatar_big'        => array(
                                            'male'=> '/assets/images/male_avatar_10.png',      // Аватарка для тех, у кого аватарки нет. Мужской род. Большой размер
                                            'female' => '/assets/images/female_avatar_10.png'  // Аватарка для тех, у кого аватарки нет. Женский род. Большой размер
                                       ),
            'not_avatar_small'      => array(
                                            'male'=> '/assets/images/male_avatar_10_small.png',      // Аватарка для тех, у кого аватарки нет. Мужской род. Маленький размер
                                            'female' => '/assets/images/female_avatar_10_small.png'  // Аватарка для тех, у кого аватарки нет. Мужской род. Маленький размер
                                       ),
            'non_image_action'      => '/assets/images/non_image_action.png'  // Изображение, которое отображается, если не задано изображение в рекламной акции
        );

        private static $profi_parametrs = array(
            'profi_about_length'          => 500,  // Длина текста  краткой информации для PROFI
            'non_profi_about_length'      => 300,  // Длина текста  краткой информации для всех
            'profi_photo_count'           => 20,   // Количество фотографий в альбоме для PROFI
            'non_profi_photo_count'       => 10,   // Количество фотографий в альбоме для всех
            'profi_personal_albums_count' => 5,    // Количество дополнительных альбомов для PROFI
            'profi_best_photos'           => 10,   // Колчиество работ в разделе Лучшие работы для PROFI
            'non_profi_best_photos'       => 5,    // Колчиество работ в разделе Лучшие работы для всех
            'profi_actions'               => 6,    // Количество рекламных акций для PROFI
            'non_profi_actions'               => 3 // Количество рекламных акций для всех

        );



        private static $rating_value = array(
            'phone'      => 10,   // Баллы рейтинга за ТЕЛЕФОН
            'skype'      => 10,   // Баллы рейтинга за учетную запись SKYPE
            'vk'         => 10,   // Баллы рейтинга за учетную запись Вконтакте
            'facebook'   => 10,   // Баллы рейтинга за учетную запись Facebook
            'twitter'    => 10,   // Баллы рейтинга за учетную запись Twitter
            'ok'         => 10,   // Баллы рейтинга за учетную запись Odnoklassniki
            'site'       => 15,   // Баллы рейтинга за веб сайт
            'avatar'     => 25,   // Баллы рейтинга за ДОБАВЛЕНИЯ АВАТАРКИ
            'comment'    => 50,   // Баллы рейтинга за ОТЗЫВ
            'bookmarks'  => 30,   // Баллы рейтинга за добавление в раздел избранного
            'actions'    => 25,   // Баллы рейтинга за рекламную акцию
            'about'      => 10,   // Баллы рейтинга за текст дополнительной информации
            'profi'      => 100,   // Баллы рейтинга за покупку статуса PROFI,
            'profi_cost' => 100   // стоимость статуса PROFI за месяц
        );


        private static $robokassa_settings = array(
            'merchant_id'      => 'astanaphotopro',
            'password_1'       => 'rI1y6K3FvILPrlxs9f0X',
            'password_2'       => 'y9cc3Nb3oDB5Vb9BKGmV',
            'test_password_1'  => 'ldUXy96dgUj9RrH68Pov',
            'test_password_2'  => 'hpshhd6IpA4FU8SX1xd0'
        );


        public static function get_profi_parametrs($key)
        {
            return self::$profi_parametrs[$key];
        }


        public static function get_rating_value($key)
        {
            return self::$rating_value[$key];
        }

        public static function get_item($key)
        {
            return self::$outer_config[$key];
        }


        public static function get_robokassa_item($key)
        {
            return self::$robokassa_settings[$key];
        }

    }


    class ErrorMessages{
        
        private static $errors = array(
            'fill_all_fileds'    => 'Заполните все поля.',
            'email_valid'        => 'Введите Email верно.',
            'birthday'           => 'Введите дату правильно.',
            'email_not_free'     => 'Этот Email уже используется в сервисе! Введите другой Email.',
            'not_email_password' => 'Email или пароль введен неверно.'
        );
        
        public static function get_error($key)
        {
            return self::$errors[$key];
        }
    }