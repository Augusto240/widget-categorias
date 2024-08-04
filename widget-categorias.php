<?php
/*
 Plugin Name: Widget Categorias
 Plugin URI: http://meusite.com
 Description: Um plugin simples que adiciona um widget para exibir uma lista de categorias.
 Version: 1.0
 Author: Seu Nome
 Author URI: http://seusite.com
*/

// Evita o acesso direto ao arquivo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Registra o widget
function wc_register_widget() {
    register_widget( 'WC_Widget_Categorias' );
}
add_action( 'widgets_init', 'wc_register_widget' );

// Define a classe do widget
class WC_Widget_Categorias extends WP_Widget {

    // Configura o widget
    public function __construct() {
        parent::__construct(
            'wc_widget_categorias', // Base ID
            'Widget Categorias', // Nome do widget
            array( 'description' => __( 'Um widget que exibe uma lista de categorias.', 'text_domain' ), ) // Args
        );
    }

    // Exibe o widget na frontend
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        echo '<ul>';
        wp_list_categories( array(
            'title_li' => '',
        ) );
        echo '</ul>';
        echo $args['after_widget'];
    }

    // Exibe o formulário no admin para configurar o widget
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Categorias', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Título:' ) ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php 
    }

    // Salva as configurações do widget
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}
