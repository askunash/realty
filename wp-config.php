<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'realty');

/** Имя пользователя MySQL */
define('DB_USER', 'realty');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'qwerty123456');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'D5BS,+[(>fp~#g&=c@&WN|l{R&LK)[jxd7z]&`fVO$.QFE[^deDrJ^7{g:+Gw),L');
define('SECURE_AUTH_KEY',  '-X1d=?-6`^>OzhqMK|bW}iByADk[/r;j:VDejHZ-RqVz;aey@mq^*@zgGI3_X`*F');
define('LOGGED_IN_KEY',    'V$r|Q@k9I_1-Yp,wA0VF1Y$JN4{Lp[Ufj!:gj,Bs=uco_;5vHR6(L#PS}_VCR4U#');
define('NONCE_KEY',        '_r2vk}=.w3qi@X7|AynGCe(1eC>Js;M_rRrNtqz_G~ctgWZXJpl~Fb;^EFKoJ-{f');
define('AUTH_SALT',        'TiUq737wV2x|BCTD)t6Bj<+uBA?dVESt^hZA *UTovQvCMeZlv[:]Npcy?jUerjP');
define('SECURE_AUTH_SALT', 'h:XVVcw3 B*CGp]+KD#(hRu4ON[XFS8sLB#QXAa2JH1OC>oM2?nUDy5rVgKJ2T=$');
define('LOGGED_IN_SALT',   ']${(O8uG*3|Lw&!3;ue6W_UTFed7.P5S2WPU{`s%sS#=UfM~QCH1SO=RHL$&I!GJ');
define('NONCE_SALT',       'Dbdan/9` Kos{OQ6Q/#Nk bsbX:pBH+IaZefRl9.?MQ<3DXg F6.,BKh;+WFb2o_');

/**#@-*/
define('FS_METHOD','direct');
/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
