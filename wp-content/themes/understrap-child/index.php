<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>
			<div class="col-6 content-area" id="primary">
				<main class="site-main" id="main">
					<?$realty_args = array(
					   'post_type' => 'realty',
					   'publish' => true,
					   'paged' => get_query_var('paged'),
					   'posts_per_page' => -20
				       	);
					/* Start the Loop */
					global $post; 
					$myposts = get_posts( $realty_args );
					foreach( $myposts as $post ){ setup_postdata($post);
						get_template_part( 'loop-templates/content-template-realty', get_post_format() );
					}
					wp_reset_postdata();
					?>
				</main><!-- #main -->
				<!-- The pagination component -->
				<?php understrap_pagination(); ?>
			</div>
			<div class="col-6 content-area" id="secondary">
				<main class="site-main" id="main">
					<?$city_args = array(
					   'post_type' => 'cities',
					   'publish' => true,
					   'paged' => get_query_var('paged'),
					   'posts_per_page' => -20
				       	);
					/* Start the Loop */
					global $post; 
					$args = array('posts_per_page' => -10); // 10 записей
					$myposts = get_posts( $city_args );
					foreach( $myposts as $post ){ setup_postdata($post);
						get_template_part( 'loop-templates/content', get_post_format() );
					}
					wp_reset_postdata();
					?>      
				</main><!-- #main -->
				<!-- The pagination component -->
				<?php understrap_pagination(); ?>
			</div>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->
		<div class="row jumbotron">
			<div class="col-md">
				
<!-- в задании нет требований к фронтенду, поэтому на него решено не обращать внимания, вообще есть скил html5+css3 и bootstrap4 -->
			<?php
			// подготовим актуальные данные по недвижимости
			$cats = get_terms('realty_type', 'orderby=name&hide_empty=0&parent=0'); // получим все термины(элементы) таксономии с иерархией
			foreach ($cats as $cat) { // пробежим по каждому полученному термину
			    $parents.="<option value='$cat->term_id' />$cat->name</option>"; // суем id и название термина в строку для вывода внутри тэга select
			    $childs_array = get_terms('realty_type', 'orderby=name&hide_empty=0&parent='.$cat->term_id); // возьмем все дочерние термины к текущему
				foreach ($childs_array as $child){
					$childs.="<option value='$child->term_id' class='$cat->term_id' />$child->name</option>";
				}
			}
			// подготовим массив с городами
			$citylist_args = array(
					   'post_type' => 'cities');
			$citieslist = get_posts($citylist_args);
			foreach ($citieslist as $ct) {
				$arcitieslist.="<option valie='$ct->ID'>$ct->post_title</option>";
			}
//			echo '<pre>'; var_dump($arcitieslist); echo '</pre>';


			?>
			<?php // Выводим форму ?>
			<form method="post" enctype="multipart/form-data" id="add_object">
				<label>Кастом категории-родители:
					<select id="parent_cats" name="parent_cats" required>
						<option value="">Не выбрано</option>
						<?php echo $parents; // выводим все родительские термины ?>
					</select>
				</label>

				<label>Кастом категории-дети:
					<select id="child_cats" name="child_cats" required>
						<option value="">Не выбрано</option>
						<?php echo $childs; // выводим все дочерние термины, плагин chained сам покажет только нужные элементы в зависимости от выбранного родительского термина ?>
					</select>
				</label>

				<!--Кастом тэги--><br />
			  	<?php echo $tags; // выводим термины таксономии без иерархии в radio ?>

				<label>Тайтл(стандартное) <input type="text" name="post_title" required/></label>
				<label>Пост контент(стандартное) <textarea name="post_content" required/></textarea></label>
				<label>Поле типа строка(Площадь) <input type="text" name="string_space"/></label>
				<label>Поле типа строка(Стоимость) <input type="text" name="string_price"/></label>
				<label>Поле типа строка(Адрес) <input type="text" name="string_address"/></label>
				<label>Поле типа строка(Жилая площадь) <input type="text" name="string_living_space"/></label>
				<label>Поле типа строка(Этаж) <input type="text" name="string_floor"/></label>
				<!-- надо дописать добавление Post Object ACF -->
				<!--label>Город:
					<select id="opt_cities" name="opt_cities" required>
						<option value="">Не выбрано</option>
						<?php echo $arcitieslist; // выводим все родительские термины ?>
					</select>
				</label-->
				<!--label>Поле типа строка(Город) <input type="text" name="string_city"/></label-->
				<label>Миниатюра(стандартное): <input type="file" name="img"/></label>
				<!--label id="first_img" class='imgs'>Дополнительные фото(произвольное): <input type='file' name='imgs[]'/></label>
				<a href="#" id="add_img">Загрузить еще фото</a-->
				<input type="submit" name="button" value="Отправить" id="sub"/>
			</form>
				<div id="output"></div> <?php // сюда будем выводить ответ ?>


<?wp_enqueue_script('newscript', get_stylesheet_directory_uri() . '/js/ajax.js');?>

			</div>
		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
