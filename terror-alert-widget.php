<?php
/*
Plugin Name: Terror Alert Level
Plugin URI: http://smartfan.pl/
Description: Widget that shows terror alert level based on news from agencies.
Author: Piotr Pesta
Version: 1.0.0
Author URI: http://smartfan.pl/
License: GPL12
*/

include 'functions.php';

class terror_alert extends WP_Widget {

// konstruktor widgetu
function terror_alert() {

	$this->WP_Widget(false, $name = __('Terror Alert', 'wp_widget_plugin') );

}

function update($new_instance, $old_instance) {
$instance = $old_instance;
// Pola
$instance['title'] = strip_tags($new_instance['title']);
$instance['level1'] = strip_tags($new_instance['level1']);
$instance['level2'] = strip_tags($new_instance['level2']);
$instance['level3'] = strip_tags($new_instance['level3']);
$instance['level4'] = strip_tags($new_instance['level4']);
$instance['level5'] = strip_tags($new_instance['level5']);
return $instance;
}

// tworzenie widgetu, back end (form)

function form($instance) {

// nadawanie i łączenie defaultowych wartości
	$defaults = array('level1' => 'Low', 'level2' => 'Moderate', 'level3' => 'Substantial', 'level4' => 'Severe', 'level5' => 'Critical', 'title' => 'Terror Alert Level');
	$instance = wp_parse_args( (array) $instance, $defaults );
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
	<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'level1' ); ?>">Level 1 label:</label>
	<input id="<?php echo $this->get_field_id( 'level1' ); ?>" name="<?php echo $this->get_field_name( 'level1' ); ?>" value="<?php echo $instance['level1']; ?>" style="width:100%;" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'level2' ); ?>">Level 2 label:</label>
	<input id="<?php echo $this->get_field_id( 'level2' ); ?>" name="<?php echo $this->get_field_name( 'level2' ); ?>" value="<?php echo $instance['level2']; ?>" style="width:100%;" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'level3' ); ?>">Level 3 label:</label>
	<input id="<?php echo $this->get_field_id( 'level3' ); ?>" name="<?php echo $this->get_field_name( 'level3' ); ?>" value="<?php echo $instance['level3']; ?>" style="width:100%;" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'level4' ); ?>">Level 4 label:</label>
	<input id="<?php echo $this->get_field_id( 'level4' ); ?>" name="<?php echo $this->get_field_name( 'level4' ); ?>" value="<?php echo $instance['level4']; ?>" style="width:100%;" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'level5' ); ?>">Level 5 label:</label>
	<input id="<?php echo $this->get_field_id( 'level5' ); ?>" name="<?php echo $this->get_field_name( 'level5' ); ?>" value="<?php echo $instance['level5']; ?>" style="width:100%;" />
</p>

<?php

}

// wyswietlanie widgetu, front end (widget)
function widget($args, $instance) {
extract( $args );

// these are the widget options
$title = apply_filters('widget_title', $instance['title']);
$level1 = $instance['level1'];
$level2 = $instance['level2'];
$level3 = $instance['level3'];
$level4 = $instance['level4'];
$level5 = $instance['level5'];
echo $before_widget;

// Check if title is set
if($title) {
echo $before_title . $title . $after_title;
}

$result = TerrorAlertFetch();

if($result<=3){
	echo '<div id="level1">'.$level1.'</div>';
}else if($result<4){
	echo '<div id="level2">'.$level2.'</div>';
}else if($result<7){
	echo '<div id="level3">'.$level3.'</div>';
}else if($result<10){
	echo '<div id="level4">'.$level4.'</div>';
}else if($result>=10){
	echo '<div id="level5">'.$level5.'</div>';
}

echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("terror_alert");'));

add_action('wp_enqueue_scripts', function () { 
        wp_enqueue_style( 'terror_alert', plugins_url('style-terror-alert.css', __FILE__));
    });

?>