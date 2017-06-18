<?php
add_action( 'widgets_init', function(){
		register_widget( 'bonuin_instagram_widget' );
	});

class bonuin_instagram_widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'bonuin_instagram_widget',
            'description' => 'This widget will display your latest posts on instagram.',
        );

        parent::__construct( 'bonuin_instagram_widget', 'Instragram Widget', $widget_ops );
    }


    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        // outputs the content of the widget
		$instagram_username = bonuin_instagram_get_user_info('user_name');
		
		?>
		
		<div class="bonuin_instagram_widget">
            <div class="instagram_widget_header">
                <div class="title">
					<?php 
                     // echo $args['before_widget'];
					  if ( ! empty( $instance['widget_title'] ) ) {
						echo $instance['widget_title'];
					}
					?>
                </div>
                <div class="company_name">
                    @<?php echo $instagram_username;?>
                </div>
            </div>
			
			
      
		
		
        
			
		
            <div class="instagram_widget_gallery">
               <?php bonuin_instagram_get_user_media('widget'); ?>
            </div>
            <div class="instagram_widget_footer">
				<a href="http://instagram.com/_u/<?php echo $instagram_username;?>/" target="_blank">View Profile</a>
                <a href=""></a>
            </div>
        </div>
		<?php 
        
        echo $args['after_widget'];
    }


    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
        $title = ! empty( $instance['widget_title'] ) ? $instance['widget_title'] : __( 'Instagram Feed', 'text_domain' );
        ?>
			<p><?php _e('Please set your instagram details in <strong>theme options</strong> for this widget to work properly','bonuin_theme');?></p>
            <p>
            <label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php _e( 'Widget Title' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
        <?php
    }


    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        foreach( $new_instance as $key => $value )
        {
            $updated_instance[$key] = sanitize_text_field($value);
        }

        return $updated_instance;
    }
}