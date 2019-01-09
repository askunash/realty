<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/jetpack.php',                         // Load Jetpack compatibility file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
	'/woocommerce.php',                     // Load WooCommerce functions.
	'/editor.php',                          // Load Editor functions.
);

foreach ( $understrap_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}

/* Add realty post type */

/*по хорошему, всё это безобразие что ниже нужно разнести по плагинам, но сами по себе они в таком виде ценности не представляют, а если делать универсальное решение, то надо дописывать и сопровождать, но это уже совсем другая история*/


function realty_register_post_type_init() {
	$labels = array(
		'name' => 'Недвижимость',
		'singular_name' => 'Недвижимость', // админ панель Добавить->Функцию
		'add_new' => 'Добавить объект',
		'add_new_item' => 'Добавить новый объект', // заголовок тега <title>
		'edit_item' => 'Редактировать объект',
		'new_item' => 'Новый объект',
		'all_items' => 'Вся недвижимость',
		'view_item' => 'Просмотр недвижимости на сайте',
		'search_items' => 'Искать объект',
		'not_found' =>  'Объектов не найдено.',
		'not_found_in_trash' => 'В корзине нет недвижимости.',
		'menu_name' => 'Недвижимость' // ссылка в меню в админке
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true, // показывать интерфейс в админке
		'has_archive' => true, 
		'menu_icon' => get_stylesheet_directory_uri() .'/img/kfm_home.png', // иконка в меню
		'menu_position' => 20, // порядок в меню
		'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail'),
		'taxanomies' => array('realty_type', '')
	);
	register_post_type('realty', $args);
}

add_action( 'init', 'realty_register_post_type_init' ); 

/* Add realty taxanomy */

function add_realty_taxonomy() {	

	register_taxonomy('realty_type',
		array('realty'),
		array(
			'hierarchical' => true,
			/* true - по типу рубрик, false - по типу меток, 
			по умолчанию - false */
			'labels' => array(
				'name' => 'Тип недвижимости',
				'singular_name' => 'Тип недвижимости',
				'search_items' =>  'Найти тип недвижимости',
				'popular_items' => 'Популярные типы недвижимости',
				'all_items' => 'Все типы недвижимости',
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => 'Редактировать тип недвижимости', 
				'update_item' => 'Обновить тип недвижимости',
				'add_new_item' => 'Добавить новый тип недвижимости',
				'new_item_name' => 'Название нового типа недвижимости',
				'separate_items_with_commas' => 'Разделяйте типы недвижимости запятыми',
				'add_or_remove_items' => 'Добавить или удалить тип недвижимости',
				'choose_from_most_used' => 'Выбрать из наиболее часто используемых типов недвижимости',
				'menu_name' => 'Тип недвижимости'
			),
			'public' => true, 
			/* каждый может использовать таксономию, либо
			только администраторы, по умолчанию - true */
			'show_in_nav_menus' => true,
			/* добавить на страницу создания меню */
			'show_ui' => true,
			/* добавить интерфейс создания и редактирования */
			'show_tagcloud' => true,
			/* нужно ли разрешить облако тегов для этой таксономии */
			'update_count_callback' => '_update_post_term_count',
			/* callback-функция для обновления счетчика $object_type */
			'query_var' => true,
			/* разрешено ли использование query_var, также можно 
			указать строку, которая будет использоваться в качестве 
			него, по умолчанию - имя таксономии */
			'rewrite' => array(
			/* настройки URL пермалинков */
				'slug' => 'platform', // ярлык
				'hierarchical' => true // разрешить вложенность
 
			),
		)
	);
}
add_action( 'init', 'add_realty_taxonomy', 0 );


/* Add cities post type */

function cities_register_post_type_init() {
	$labels = array(
		'name' => 'Города',
		'singular_name' => 'Город', // админ панель Добавить->Функцию
		'add_new' => 'Добавить город',
		'add_new_item' => 'Добавить новый город', // заголовок тега <title>
		'edit_item' => 'Редактировать город',
		'new_item' => 'Новый город',
		'all_items' => 'Все города',
		'view_item' => 'Просмотр городов на сайте',
		'search_items' => 'Искать города',
		'not_found' =>  'Городов не найдено.',
		'not_found_in_trash' => 'В корзине нет городов.',
		'menu_name' => 'Города' // ссылка в меню в админке
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true, 
		'has_archive' => true, 
		'menu_icon' => get_stylesheet_directory_uri() .'/img/cities.png', 
		'menu_position' => 20, 
		'supports' => array( 'title', 'editor', 'comments', 'author', 'thumbnail'),
		//'taxanomies' => array('realty_type', '')
	);
	register_post_type('cities', $args);
}

add_action( 'init', 'cities_register_post_type_init' ); 

function echo_realt_info( $post_content ){
	
	$space = get_field( "space" );
	$price = get_field( "price" );
	$address = get_field( "address" );
	$living_space = get_field( "living_space" );
	$floor = get_field( "floor" );
	$city = get_field( "city" );
	$cpost = get_post($city[0]);  
	$cargs = array(); 
	$ptype = get_post_type();
	if ($ptype === 'realty') {
		if (is_single()) {
			$post_content .= 'Площадь: '.$space.'<br>'.'Цена: '.$price.'<br>'.'Адрес: '.$address.'<br>'.'Жилая площадь: '.$living_space.'<br>'.'Этаж: '.$floor.'<br>'.'Город: '.$cpost->post_title.'<br>';
		}
		else { 
		
			$post_content .= 'Площадь: '.$space.' '.'Цена: '.$price.' '.'Адрес: '.$address.' '.'Жилая площадь: '.$living_space.' '.'Этаж: '.$floor.' '.'Город: '.$cpost->post_title.' ';
		}
	}
		return $post_content;
}

add_filter( 'the_content', 'echo_realt_info' );


function include_scripts(){
        wp_enqueue_script('jquery'); // добавим основную библиотеку jQuery
        wp_enqueue_script('jquery-form'); // добавим плагин jQuery forms, встроен в WP
        wp_enqueue_script('jquery-chained', '//www.appelsiini.net/projects/chained/jquery.chained.min.js'); // добавим плагин для связанных селект листов

        wp_localize_script( 'jquery', 'ajaxdata', // функция для передачи глобальных js переменных на страницу, первый аргумент означет перед каким скриптом вставить переменные, второй это название глобального js объекта в котором эти переменные будут храниться, последний аргумент это массив с самими переменными
			array( 
   				'url' => admin_url('admin-ajax.php'), // передадим путь до нативного обработчика аякс запросов в wp, в js можно будет обратиться к ней так: ajaxdata.url
   				'nonce' => wp_create_nonce('add_object') // передадим уникальную строку для механизма проверки аякс запроса, ajaxdata.nonce
			)
		);
}

add_action('wp_print_scripts','include_scripts'); // действие в котором прикрепим необходимые js скрипты и передадим данные 



function add_object() {
	$errors = ''; // сначала ошибок нет

	$nonce = $_POST['nonce']; // берем переданную формой строку проверки
	if (!wp_verify_nonce($nonce, 'add_object')) { // проверяем nonce код, второй параметр это аргумент из wp_create_nonce
		$errors .= 'Данные отправлены с левой страницы '; // пишим ошибку
	}

	// запишем все поля
	$parent_cat = (int)$_POST['parent_cats']; // переданный id термина таксономии с вложенностью (родитель)
	$child_cat = (int)$_POST['child_cats']; // id термина таксономии с вложенностью (его дочка)
	$tag = (int)$_POST['tag']; // id обычной таксономии
	$title = strip_tags($_POST['post_title']); // запишем название поста
	$content = wp_kses_post($_POST['post_content']); // контент
	$string_space = strip_tags($_POST['string_space']); // произвольное поле типа строка
	$string_price = strip_tags($_POST['string_price']); // произвольное поле типа строка
	$string_address = strip_tags($_POST['string_address']); // произвольное поле типа строка
	$string_living_space = strip_tags($_POST['string_living_space']); // произвольное поле типа строка
	$string_floor = strip_tags($_POST['string_floor']); // произвольное поле типа строка
	$opt_cities = strip_tags($_POST['opt_cities']); // город
	$opt_cities = array('0'=>'a:1:{i:0;s:2:"'.$opt_cities.'";}'); // значение для поля город
	//$text_field = wp_kses_post($_POST['text_field']); // произвольное поле типа текстарея

	// проверим заполненность, если пусто добавим в $errors строку
	if (!$parent_cat) $errors .= 'Не выбрано "Кастом категория-родитель"';
   // if (!$child_cat) $errors .= 'Не выбрано "Кастом категория-ребенок xD"';				    
   // if (!$tag) $errors .= 'Не выбрано "Кастом тэг"';
    if (!$title) $errors .= 'Не заполнено поле "Тайтл"';
    if (!$content) $errors .= 'Не заполнено поле "Пост контент"';
    if (!$string_space) $errors .= 'Не заполнено поле "Площадь"';
    if (!$string_price) $errors .= 'Не заполнено поле "Цена"';
    if (!$string_address) $errors .= 'Не заполнено поле "Адрес"';
    if (!$string_living_space) $errors .= 'Не заполнено поле "Жилая площадь"';
    if (!$string_floor) $errors .= 'Не заполнено поле "Этаж"';
    if (!$opt_cities) $errors .= 'Не выбран город';

    // далее проверим все ли нормально с картинками которые нам отправили
    if ($_FILES['img']) { // если была передана миниатюра
   		if ($_FILES['img']['error']) $errors .= "Ошибка загрузки: " . $_FILES['img']['error'].". (".$_FILES['img']['name'].") "; // серверная ошибка загрузки
    	$type = $_FILES['img']['type']; 
		if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png")) $errors .= "Формат файла может быть только jpg или png. (".$_FILES['img']['name'].")"; // неверный формат
	}

	if ($_FILES['imgs']) { // если были переданны дополнительные картинки, пробежимся по ним в цикле и проверим тоже самое
		foreach ($_FILES['imgs']['name'] as $key => $array) {
			if ($_FILES['imgs']['error'][$key]) $errors .= "Ошибка загрузки: " . $_FILES['imgs']['error'][$key].". (".$key.$_FILES['imgs']['name'][$key].") ";
    		$type = $_FILES['imgs']['type'][$key]; 
			if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png")) $errors .= "Формат файла может быть только jpg или png. (".$_FILES['imgs']['name'][$key].")"; 
		}
	}  

	if (!$errors) { // если с полями все ок, значит можем добавлять пост
		$fields = array( // подготовим массив с полями поста, ключ это название поля, значение - его значение
			'post_type' => 'realty', // нужно указать какой тип постов добавляем, у нас это my_custom_post_type
	    	'post_title'   => $title, // заголовок поста
	        'post_content' => $content, // контент
	    );
	    $post_id = wp_insert_post($fields); // добавляем пост в базу и получаем его id

	    update_post_meta($post_id, 'space', $string_space); // заполняем произвольное поле типа строка
	    update_post_meta($post_id, 'price', $string_price); // заполняем произвольное поле типа строка
	    update_post_meta($post_id, 'address', $string_address); // заполняем произвольное поле типа строка
	    update_post_meta($post_id, 'living_space', $string_living_space); // заполняем произвольное поле типа строка
	    update_post_meta($post_id, 'floor', $string_floor); // заполняем произвольное поле типа строка
//	    update_post_meta($post_id, 'city', $opt_cities); // заполняем произвольное поле привязки к городу
//	    update_field('city', $opt_cities, $post_id);
//	    update_post_meta($post_id, 'text_field', $text_field); // заполняем произвольное поле типа текстарея

	    wp_set_object_terms($post_id, $parent_cat, 'realty_type', true); //var_dump($parent_cat); // привязываем к пост к таксономиям, третий параметр это слаг таксономии
	    wp_set_object_terms($post_id, $child_cat, 'realty_type', true);
//	    wp_set_object_terms($post_id, $tag, 'custom_tax_like_tag', true);

	    if ($_FILES['img']) { // если основное фото было загружено
   			$attach_id_img = media_handle_upload( 'img', $post_id ); // добавляем картинку в медиабиблиотеку и получаем её id
   			update_post_meta($post_id,'_thumbnail_id',$attach_id_img); // привязываем миниатюру к посту
		}

		if ($_FILES['imgs']) { // если дополнительные фото были загружены
			$imgs = array(); // из-за того, что дефолтный массив с загруженными файлами в пхп выглядит не так как нужно, а именно вся инфа о файлах лежит в разных массивах но с одинаковыми ключами, нам нужно создать свой массив с блэкджеком, где у каждого файла будет свой массив со всеми данными
			foreach ($_FILES['imgs']['name'] as $key => $array) { // пробежим по массиву с именами загруженных файлов
				$file = array( // пишем новый массив
					'name' => $_FILES['imgs']['name'][$key],
					'type' => $_FILES['imgs']['type'][$key], 
					'tmp_name' => $_FILES['imgs']['tmp_name'][$key], 
					'error' => $_FILES['imgs']['error'][$key],
					'size' => $_FILES['imgs']['size'][$key]
				);
				$_FILES['imgs'.$key] = $file; // записываем новый массив с данными в глобальный массив с файлами
				$imgs[] = media_handle_upload( 'imgs'.$key, $post_id ); // добавляем текущий файл в медиабиблиотека, а id картинки суем в другой массив
			}
			update_post_meta($post_id,'multifile_field',$imgs); // привязываем все картинки к посту
		}  
	}

	if ($errors) wp_send_json_error($errors); // если были ошибки, выводим ответ в формате json с success = false и умираем
	else wp_send_json_success('Все прошло отлично! Добавлено ID:'.$post_id); // если все ок, выводим ответ в формате json с success = true и умираем
	
	die(); // умрем еще раз на всяк случ
}

add_action( 'wp_ajax_nopriv_add_object_ajax', 'add_object' ); // крепим на событие wp_ajax_nopriv_add_object_ajax, где add_object_ajax это параметр action, который мы добавили в перехвате отправки формы, add_object - ф-я которую надо запустить
add_action('wp_ajax_add_object_ajax', 'add_object'); // если нужно чтобы вся бадяга работала для админов

