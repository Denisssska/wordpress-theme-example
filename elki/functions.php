<?php

use JetBrains\PhpStorm\Pure;

//добавляем обновление лого в шапке


if (!function_exists('blog_setup')) {
    function blog_setup()
    {
        add_theme_support('custom-logo', [
            'height' => 50,
            'width' => 223,
            'flex-width' => true,
            'flex-height' => false,
            'header-text' => '',
        ]);//добавили пользовательский логотип
        add_theme_support('title-tag');//добавляем динамический тег <title>
        add_theme_support('post-thumbnails');//добавляем миниатюру посту

    }

    add_action('after_setup_theme', 'blog_setup');//добавить событие :когда подключает тему мы подключаем функцию для вывода лого
}

// правильный способ подключить стили и скрипты
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
    // wp_enqueue_style('main', get_stylesheet_uri());//add stile.css in blog dir
    wp_enqueue_style('blog-style', get_template_directory_uri() . '/assets/css/main.css', array(), null);
    wp_enqueue_style('header-style', get_template_directory_uri() . '/assets/css/menu-header.css', array(), null);
    wp_enqueue_style('contacts-style', get_template_directory_uri() . '/assets/css/contacts.css', array(), null);
    wp_enqueue_style('about-style', get_template_directory_uri() . '/assets/css/about.css', array(), null);

//    wp_deregister_script( 'jquery' );
//    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js');
    // wp_enqueue_script( 'jquery' );

    wp_enqueue_script('script-jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array('jquery'), null, true);
    wp_enqueue_script('script-browser', get_template_directory_uri() . '/assets/js/browser.min.js', array('jquery'), null, true);
    wp_enqueue_script('script-breakpoints', get_template_directory_uri() . '/assets/js/breakpoints.min.js', array('jquery'), null, true);
    wp_enqueue_script('script-util', get_template_directory_uri() . '/assets/js/util.js', array('jquery'), null, true);
    wp_enqueue_script('script-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true);
    wp_enqueue_script('script-header', get_template_directory_uri() . '/assets/js/header.js', array('jquery'), null, true);
});


/////////добавить файл php
//require_once get_template_directory_uri() . '/custom-post-types.php';


//убрать админ навбар
function noSubsAdminBar()
{
    show_admin_bar(false);
}

add_action('wp_loaded', 'noSubsAdminBar');

//регистрируем несколько областей меню
function blog_register_menus()
{//собираем зоны меню и регистрируем их
    register_nav_menus(
        array(
            'header_menu' => esc_html__('Header Menu', 'elki-les'),
            'side_menu' => 'Левый сайдбар',
            'footer_menu' => esc_html__('Footer Menu', 'elki-les'),
            'mobile_menu' => esc_html__('Mobile (optional)', 'elki-les'),
        )
    );
}

add_action('init', 'blog_register_menus');

//
//add_filter('nav_menu_css_class', 'custom_nav_menu_css_class', 10, 1);
//function custom_nav_menu_css_class($classes): array
//{
//    //добавляем  к списку класов наш класс nav
//    $classes[] = 'navbar-nav';
//
//    return $classes;
//}
//


// создание кастомного поста в админке
add_action('init', 'register_post_type_init');
function register_post_type_init()
{

    $labels = array(
        'name' => 'Кастом',
        'singular_name' => 'Кастом',
        'add_new' => 'Добавить Кастом',
        'add_new_item' => 'Добавить Кастом',
        'edit_item' => 'Редактировать Кастом',
        'new_item' => 'Новый Кастом',
        'all_items' => 'Все Кастомы',
        'search_items' => 'Искать Кастом',
        'not_found' => 'Кастомов по заданным критериям не найдено.',
        'not_found_in_trash' => 'В корзине нет Кастомов.',
        'menu_name' => 'Кастомы'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'has_archive' => false,
        'menu_icon' => null,
        'menu_position' => 2,
        'supports' => array('title', 'editor')
    );

    register_post_type('lead', $args);
}


// сообщения, которые появляются в верхней части экрана при например сохранении или обновлении поста.
add_filter('post_updated_messages', 'true_post_type_messages');
function true_post_type_messages($messages)
{

    global $post, $post_ID;

    $messages['lead'] = array( // lead - название созданного нами типа записей
        0 => '', // Данный индекс не используется.
        1 => 'Кастом обновлён.',
        2 => 'Поле изменено.',
        3 => 'Поле удалено.',
        4 => 'Кастом обновлён.',
        5 => isset($_GET['revision']) ? sprintf('Кастом восстановлен из редакции из редакции: %s', wp_post_revision_title((int)$_GET['revision'], false)) : false,
        6 => 'Кастом добавлен.',
        7 => 'Кастом сохранён.',
        8 => 'Отправлено на проверку.',
        9 => sprintf('Кастом запланирован на публикацию на <strong>%1$s</strong>.', date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date))),
        10 => 'Черновик Кастома сохранён',
    );

    return $messages;
}


//сообщения быстрого редактирования постов.
add_filter('bulk_post_updated_messages', 'true_bulk_post_updated_messages', 25, 2);

#[Pure] function true_bulk_post_updated_messages($messages, $counts): array
{
    $bulk_messages['lead'] = array(
        // не совсем правильный способ, но уже полностью рабочий прямо сейчас
        'updated' => $counts['updated'] . ' ' . true_wordform($counts['updated'], 'Кастом', 'Кастома', 'Кастомов') . ' обновлено.',
        'locked' => $counts['locked'] . ' ' . true_wordform($counts['locked'], 'Кастом', 'Кастома', 'Кастомов') . ' не обновлено, потому что кто-то редактирует их.',
        'deleted' => $counts['deleted'] . ' ' . true_wordform($counts['deleted'], 'Кастом', 'Кастома', 'Кастомов') . ' удалено безвозвратно.',
        'trashed' => $counts['deleted'] . ' ' . true_wordform($counts['deleted'], 'Кастом', 'Кастома', 'Кастомов') . ' перемещено в корзину.',
        // правильный способ, это когда наш код поддерживает локализацию
        // но при написание чего-либо для себя, возможно в этом и нет большого смысла
        // 'untrashed' => _n( '%s lead restored from the Trash.', '%s leads restored from the Trash.', $bulk_counts[ 'untrashed' ] ),
    );

    return $bulk_messages;

}

////////////////////////функция для склонения слов
/*
 * $num число, от которого будет зависеть форма слова
 * $form_for_1 первая форма слова, например Товар
 * $form_for_2 вторая форма слова - Товара
 * $form_for_5 третья форма множественного числа слова - Товаров
 */
function true_wordform($num, $form_for_1, $form_for_2, $form_for_5)
{
    $num = abs($num) % 100; // берем число по модулю и сбрасываем сотни (делим на 100, а остаток присваиваем переменной $num)
    $num_x = $num % 10; // сбрасываем десятки и записываем в новую переменную
    if ($num > 10 && $num < 20) // если число принадлежит отрезку [11;19]
        return $form_for_5;
    if ($num_x > 1 && $num_x < 5) // иначе если число оканчивается на 2,3,4
        return $form_for_2;
    if ($num_x == 1) // иначе если оканчивается на 1
        return $form_for_1;
    return $form_for_5;
}

///////////////////добавим вкладку ПОМОЩЬ
add_action('admin_head', 'true_post_type_help_tab', 25);

function true_post_type_help_tab()
{
    $screen = get_current_screen();

    // Прекращаем выполнение функции, если находимся на страницах других типов постов
    if ('lead' !== $screen->post_type) {
        return;
    }

    // Добавляем первую вкладку
    $screen->add_help_tab(array(
        'id' => 'tab_1',
        'title' => 'Общая информация',
        'content' => '<h3>Общая информация</h3><p>На этой странице вы сможете найти все заявки, отправленные через формы обрутной связи на странице контактов.</p>'
    ));

    // Добавляем вторую вкладку
    $screen->add_help_tab(array(
        'id' => 'tab_2',
        'title' => 'Вторая вкладка',
        'content' => '<h3>Вторая вкладка</h3><p>Содержимое второй вкладки</p>'
    ));

}

//////////////добавим ещё одну колонку, в которой будет выводиться текст сообщения лида.
add_filter('manage_edit-lead_columns', 'true_add_lead_columns', 25);

function true_add_lead_columns($columns): array
{
    $message = array('message' => 'Сообщение');
    return array_slice($columns, 0, 2, true) + $message + array_slice($columns, 2, NULL, true);
}

add_action('manage_posts_custom_column', 'true_fill_lead_columns', 25);

function true_fill_lead_columns($column)
{

    switch ($column) {
        case 'message':
        {
            global $post;
            echo wpautop(esc_html($post->post_content));
            break;
        }
    }

}

///////// зарегистрируем таксономию для нового поста Кастом
add_action('init', function () {
    register_taxonomy('country', 'lead',
        array(
            'public' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'labels' => array(
                'menu_name' => 'Страна')
        ),

    );
});


//////добавим сайдбары в виджеты
function true_register_wp_sidebars()
{

    /* В боковой колонке - первый сайдбар */
    register_sidebar(
        array(
            'id' => 'contacts_first_side', // уникальный id
            'name' => 'contacts first column', // название сайдбара

            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
            'after_title' => '</h2>'
        )
    );
    register_sidebar(
        array(
            'id' => 'contacts_second_side', // уникальный id
            'name' => 'contacts second column', // название сайдбара

            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
            'after_widget' => '</div>',
            'before_title' => '<p class="widget-title">', // по умолчанию заголовки виджетов в <h2>
            'after_title' => '</p>'
        )
    );

    /* В подвале - второй сайдбар */
    register_sidebar(
        array(
            'id' => 'contacts_three_side',
            'name' => 'Футер',
            'show_in_nav_menus' => true,
            'description' => 'Перетащите сюда виджеты, чтобы добавить их в футер.',
            'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>'
        )
    );
}

add_action('widgets_init', 'true_register_wp_sidebars');


////////////////создание кастомного виджета
class trueTopPostsWidget extends WP_Widget
{

    /*
     * создание виджета
     */
    function __construct()
    {
        parent::__construct(
            'true_top_widget',
            'Популярные посты', // заголовок виджета
            array('description' => 'Позволяет вывести посты, отсортированные по количеству комментариев в них.') // описание
        );
    }

    /*
     * фронтэнд виджета
     */
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']); // к заголовку применяем фильтр (необязательно)
        $posts_per_page = $instance['posts_per_page'];

        echo $args['before_widget'];

        if (!empty($title))
            echo $args['before_title'] . $title . $args['after_title'];

        $q = new WP_Query("posts_per_page=$posts_per_page&orderby=comment_count");
        if ($q->have_posts()):
            ?>
            <ul><?php
            while ($q->have_posts()): $q->the_post();
                ?>
                <li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li><?php
            endwhile;
            ?></ul><?php
        endif;
        wp_reset_postdata();

        echo $args['after_widget'];
    }

    /*
     * бэкэнд виджета
     */
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        if (isset($instance['posts_per_page'])) {
            $posts_per_page = $instance['posts_per_page'];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Заголовок</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('posts_per_page'); ?>">Количество постов:</label>
            <input id="<?php echo $this->get_field_id('posts_per_page'); ?>"
                   name="<?php echo $this->get_field_name('posts_per_page'); ?>" type="text"
                   value="<?php echo ($posts_per_page) ? esc_attr($posts_per_page) : '5'; ?>" size="3"/>
        </p>
        <?php
    }

    /*
     * сохранение настроек виджета
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['posts_per_page'] = (is_numeric($new_instance['posts_per_page'])) ? $new_instance['posts_per_page'] : '5'; // по умолчанию выводятся 5 постов
        return $instance;
    }
}

/*
 * регистрация виджета
 */
function true_top_posts_widget_load()
{
    register_widget('trueTopPostsWidget');
}

add_action('widgets_init', 'true_top_posts_widget_load');

//добавим обращение к базе

//wp_localize_script('js-script', 'my-data', [
//    'root_url' => get_site_url(),
//    'nonce' => wp_create_nonce('wp_rest') //create secret key for CRUD
//]); //allow get object_name in each file

add_action('rest_api_init', 'get_all_posts_items');
function get_all_posts_items()
{
    register_rest_route('den', '/all-posts', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => function (WP_REST_Request $request) {

            global $wpdb;
//            $start = $request['start'];
            return $wpdb->get_results("SELECT * FROM `wp_posts` ORDER BY `post_name` DESC");
        },
//        'args' => array(
//            'start' => array(
//                'type'     => 'string',
//                'required' => true,
//            ),
//            'range' => array(
//                'type'     => 'string',
//                'required' => true,
//            ),
//            'userID' => array(
//                'type'     => 'string',
//                'required' => true,
//            ),
//        )
    ));
}

add_action('rest_api_init', 'get_all_comments_items');
function get_all_comments_items()
{
    register_rest_route('den', '/all-comments', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => function (WP_REST_Request $request) {
            global $wpdb;

//            $start = $request['start'];
            return $wpdb->get_results("SELECT * FROM `wp_comments` ORDER BY `comment_content` DESC");
        }
    ));
}

add_action('rest_api_init', 'create_comment');
function create_comment()
{
    register_rest_route('den', '/new-comment', array(
        'methods' => WP_REST_Server::CREATABLE,
        //'args' => (new WP_REST_Request)->get_params(),
        //'args' => (new WP_REST_Request)->get_query_params(),
        'callback' => function (WP_REST_Request $request) {
            global $wpdb;
            $parameters = $request->get_params(); // Array([id] => 1)

            // При необходимости также доступны отдельные параметры параметров:
            //  $parameters = $request->get_url_params(); // Array([id] => 1)

            // $parameters = $request->get_query_params(); // Array()
            // Если запросить http://wp-test.ru/wp-json/myplugin/v1/author/1?post=1
            //  $parameters = $request->get_query_params(); // Array( [post] => 1 )

            //$parameters = $request->get_body_params(); // Array()
            //$parameters = $request->get_json_params(); // null - не было запроса с заголовком Content-type: application/json
            //$parameters = $request->get_default_params(); // Array()

            // Данные о загрузках не объединены, но могут быть доступны отдельно:
            //$parameters = $request->get_file_params();

            //return $wpdb->get_results("INSERT INTO  `wp_comments` VALUES $parameters");
            //return $wpdb->get_results("INSERT INTO  `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES ('$parameters')");
//return $parameters;
        },
//        'args' => array(
//            'comment_ID' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_agent' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_approved' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_author' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//
//            'comment_author_IP' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_author_email' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_author_url' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_content' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_date' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//
//            'comment_date_gmt' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_karma' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_parent' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_post_ID' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'comment_type' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//            'user_id' => array(
//                'type' => 'string',
//                'required' => true,
//            ),
//        )
    ));
}


//добавим шорткод
function shortcode_func($atts): string
{
    $html = '<form action="' . get_permalink() . '" method="POST">
        <ul class="form-section-ul">
            <li><input type="text" name="name" required="true" placeholder="Имя *" /></li>
            <li><input type="text" name="email" required="true" placeholder="Email *" /></li>
            <li><textarea name="soobschenie" required="true" placeholder="Сообщение *"></textarea></li>
            <li><button>Отправить</button></li>
        </ul>
                    </form>';
    return $html;
    //return site_url(); // никаких echo, только return
    // return ' 8 029 574 39 21';
}

add_shortcode('shortcode', 'shortcode_func');

//////добавить метабоx в админку
add_action( 'add_meta_boxes', 'true_add_metabox' );

function true_add_metabox() {

    add_meta_box(
        'seo_metabox', // ID нашего метабокса
        'SEO настройки поста', // заголовок
        'seo_metabox_callback', // функция, которая будет выводить поля в мета боксе
        'page', // типы постов, для которых его подключим
        'normal', // расположение (normal, side, advanced)
        'default' // приоритет (default, low, high, core)
    );

}
////Добавляем поля в метабокс
///
function seo_metabox_callback( $post ) {
    // сначала получаем значения этих полей
    // заголовок
    $seo_title = get_post_meta( $post->ID, 'seo_title', true );
    // скрытие от поисковиков
    $seo_robots = get_post_meta( $post->ID, 'seo_robots', true );

    // одноразовые числа, кстати тут нет супер-большой необходимости их использовать
    wp_nonce_field( 'seopostsettingsupdate-' . $post->ID, '_truenonce' );

    echo '<table class="form-table">
		<tbody>
			<tr>
				<th><label for="seo_title">SEO-заголовок</label></th>
				<td><input type="text" id="seo_title" name="seo_title" value="' . esc_attr( $seo_title ) . '" class="regular-text"></td>
			</tr>
			<tr>
				<th>Скрыть из поисковиков</th>
				<td>
					<label><input type="checkbox" name="seo_robots" ' . checked( 'yes', $seo_robots, false ) . ' /> Да</label>
				</td>
			</tr>
		</tbody>
	</table>';
}

///// Сохранение значений полей метабокса
add_action( 'save_post', 'true_save_meta', 10, 2 );

function true_save_meta( $post_id, $post ) {

    // проверка одноразовых полей
    if ( ! isset( $_POST[ '_truenonce' ] ) || ! wp_verify_nonce( $_POST[ '_truenonce' ], 'seopostsettingsupdate-' . $post->ID ) ) {
        return $post_id;
    }

    // проверяем, может ли текущий юзер редактировать пост
    $post_type = get_post_type_object( $post->post_type );

    if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
        return $post_id;
    }

    // ничего не делаем для автосохранений
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return $post_id;
    }

    // проверяем тип записи
    if( 'page' !== $post->post_type ) {
        return $post_id;
    }

    if( isset( $_POST[ 'seo_title' ] ) ) {
        update_post_meta( $post_id, 'seo_title', sanitize_text_field( $_POST[ 'seo_title' ] ) );
    } else {
        delete_post_meta( $post_id, 'seo_title' );
    }
    if( isset( $_POST[ 'seo_robots' ] ) && 'on' == $_POST[ 'seo_robots' ] ) {
        update_post_meta( $post_id, 'seo_robots', 'yes' );
    } else {
        delete_post_meta( $post_id, 'seo_robots' );
    }

    return $post_id;

}
////Вывод полей на сайте

add_filter( 'pre_get_document_title', 'true_seo_title', 25 );

function true_seo_title(){

    if( is_page() && ( $title = get_post_meta( get_the_ID(), 'seo_title', true ) ) ) {
        return $title;
    }

    return '';

}
/////метатеги robots
add_action( 'wp_head', 'true_seo_robots', 25 );

function true_seo_robots() {

    if( ! is_page() ) {
        return;
    }

    if( 'yes' === get_post_meta( get_the_ID(), 'seo_robots', true ) ) {
        echo '<meta name="robots" content="noindex,nofollow" />';
    }
}
//создание метабокса с помощью плагина Carbon Fields
//use Carbon_Fields\Container;
//use Carbon_Fields\Field;
//
//add_action( 'carbon_fields_register_fields', 'truemisha_carbon_seo' );
//function truemisha_carbon_seo() {
//
//    Container::make( 'post_meta', 'SEO настройки поста' )
//        ->where( 'post_type', '=', 'page' )
//        ->add_fields( array(
//
//            Field::make( 'text', 'seo_title', 'SEO-заголовок' ),
//            Field::make( 'checkbox', 'seo_robots', 'Скрыть из поисковиков' )->set_option_value( 'yes' )
//
//        ) );
//
//}
