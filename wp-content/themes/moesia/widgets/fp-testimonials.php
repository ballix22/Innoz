<?php

class Moesia_Testimonials extends WP_Widget {

// constructor
    function moesia_testimonials() {
		$widget_ops = array('classname' => 'moesia_testimonials_widget', 'description' => __( 'Display testimonials from your clients.', 'moesia') );
        parent::WP_Widget(false, $name = __('Moesia FP: Testimonials', 'moesia'), $widget_ops);
		$this->alt_option_name = 'moesia_testimonials_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	// widget form creation
	function form($instance) {

	// Check values
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$image_uri = isset( $instance['image_uri'] ) ? esc_url_raw( $instance['image_uri'] ) : '';		
	?>
	
	<p><?php _e('In order to display this widget, you must first add some testimonials from the dashboard. Add as many as you want and the theme will automatically display them all.', 'moesia'); ?></p>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'moesia'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

    <?php
        if ( $image_uri != '' ) :
           echo '<p><img class="custom_media_image" src="' . $image_uri . '" style="max-width:100px;" /></p>';
        endif;
    ?>
    <p><label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Upload an image for the background if you want. It will get a parallax effect.', 'moesia'); ?></label></p> 
    <p><input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo $this->get_field_name('image_uri'); ?>" value="Upload Image" style="margin-top:5px;" /></p>
	<p><input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'image_uri' ); ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" type="text" value="<?php echo $image_uri; ?>" size="3" /></p>	
	
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
	    $instance['image_uri'] = esc_url_raw( $new_instance['image_uri'] );			
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['moesia_testimonials']) )
			delete_option('moesia_testimonials');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('moesia_testimonials', 'widget');
	}
	
	// display widget
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'moesia_testimonials', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'What our clients say', 'moesia' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$image_uri = isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';		

		/**
		 * Filter the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'testimonials'
		) ) );

		if ($r->have_posts()) :
?>
		<section id="testimonials" class="testimonials-area">
			<div class="container">
				<?php if ( $title ) echo $before_title . $title . $after_title; ?>
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					<?php $function = get_post_meta( get_the_ID(), 'wpcf-client-function', true ); ?>
					<?php $photo = get_post_meta( get_the_ID(), 'wpcf-client-photo', true ); ?>
					<div class="testimonial col-md-6 col-sm-6">
						<div class="testimonial-body"><?php the_content(); ?></div>
						<?php if ($photo != '') : ?>
							<img class="client-photo col-md-4" src="<?php echo esc_url($photo); ?>" alt="<?php the_title(); ?>">
						<?php endif; ?>
						<h4 class="client-name col-md-8"><?php the_title(); ?></h4>
						<?php if ($function != '') : ?>
							<span class="client-function col-md-8"><?php echo esc_html($function); ?></span>
						<?php endif; ?>						
					</div>
				<?php endwhile; ?>
			</div>
		<?php if ($image_uri != '') : ?>
			<style type="text/css">
				.testimonials-area {
				    display: block;			    
					background: url(<?php echo $image_uri; ?>) no-repeat;
					background-position: center top;
					background-attachment: fixed;
					background-size: cover;
					z-index: -1;
				}
			</style>
		<?php endif; ?>				
		</section>		
	<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'moesia_testimonials', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}