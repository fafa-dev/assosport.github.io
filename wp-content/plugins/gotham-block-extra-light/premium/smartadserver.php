<?php 
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

// Widget PREMIUM

class gothamblockadblock_smartban_widget extends WP_Widget {
	
	function __construct() {
	parent::__construct(
	 
	// Base ID of your widget
	'gothamblockadblock_smartban_widget', 
	  
	// Widget name will appear in UI
	__('.: AntiAdblock 4 Banners :.', 'gothamblockadblock_smartban_widget'), 
	  
	// Widget description
	array( 'description' => __( 'Unblock Ad Banners', 'gothamblockadblock_smartban_widget' ), ) 
	);
	}
	  
	// Creating widget front-end
	  
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$url = isset($instance['url']) ? $instance['url'] : NULL;  
		$image_url = isset($instance['image_url']) ? $instance['image_url'] : NULL;
		$alt = apply_filters( 'widget_title', $instance['alt'] );
		$target = apply_filters( 'widget_title', $instance['target'] );
		$cloaking = apply_filters( 'widget_title', $instance['cloaking'] );
		$width = apply_filters( 'widget_title', $instance['width'] );
		$height = apply_filters( 'widget_title', $instance['height'] );

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];

		if (! empty( $title ) ) { echo $args['before_title'] . $title . $args['after_title'];}
		
		// This is where you run the code and display the output
		echo do_shortcode( "[ghostban url='$url' image_url = '$image_url' alt='$alt' target='$target' cloaking='$cloaking' width='$width' height='$height']" );
				
		echo $args['after_widget'];
	}
			  
	// Widget Backend 
	public function form( $instance ) {
		
		if ( isset( $instance[ 'title' ] ) ) {
			
			$title = $instance[ 'title' ];
			
		} else {
			
			$title = __( 'Deal', 'gothamblockadblock_smartban_widget' );
			
		}
		
		$url = isset($instance[ 'url' ]) ? $instance[ 'url' ] : NULL;
		$image_url = isset($instance[ 'image_url' ]) ? $instance[ 'image_url' ]: NULL;
		$alt = isset($instance[ 'alt' ]) ? $instance[ 'alt' ]: NULL;
		$target = isset($instance[ 'target' ]) ? $instance[ 'target' ]: NULL;
		$cloaking = isset($instance[ 'cloaking' ]) ? $instance[ 'cloaking' ]: NULL;
		$width = isset($instance[ 'width' ]) ? $instance[ 'width' ]: NULL;
		$height = isset($instance[ 'height' ]) ? $instance[ 'height' ]: NULL;
		
		// Widget admin form
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>">🔗 URL</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'image_url' ); ?>">🦞 Image Url</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'image_url' ); ?>" name="<?php echo $this->get_field_name( 'image_url' ); ?>" type="text" value="<?php echo esc_attr( $image_url ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'alt' ); ?>">⚓ ALT</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'alt' ); ?>" name="<?php echo $this->get_field_name( 'alt' ); ?>" type="text" value="<?php echo esc_attr( $alt ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>">↔️ Width</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>">↗️ Height</label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $height ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'target' ); ?>">🎯 Target</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'target' ); ?>" name="<?php echo $this->get_field_name( 'target' ); ?>">
					<?php
					// Your options array
					$options = array(
						'blank' => __( 'blank', 'blank' ),
						'self' => __( 'self', 'self' ),
					);
					// Loop through options and add each one to the select dropdown
					foreach ( $options as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $target, $key, false ) . '>'. $name . '</option>';
					} ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cloaking' ); ?>">👻 Cloaking</label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'cloaking' ); ?>" name="<?php echo $this->get_field_name( 'cloaking' ); ?>">
					<?php
					// Your options array
					$options = array(
						'yes' => __( 'oui', 'oui' ),
						'no' => __( 'non', 'non' ),
					);
					// Loop through options and add each one to the select dropdown
					foreach ( $options as $key => $name ) {
						echo '<option value="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '" '. selected( $cloaking, $key, false ) . '>'. $name . '</option>';
					} ?>
			</select>
		</p>
		<?php 
	}
	  
// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : NULL;
		$instance['url'] = ( ! empty( $new_instance['url'] ) ) ? strip_tags( $new_instance['url'] ) : NULL;
		$instance['image_url'] = ( ! empty( $new_instance['image_url'] ) ) ? strip_tags( $new_instance['image_url'] ) : NULL;
		$instance['alt'] = ( ! empty( $new_instance['alt'] ) ) ? strip_tags( $new_instance['alt'] ) : NULL;
		$instance['target'] = ( ! empty( $new_instance['target'] ) ) ? strip_tags( $new_instance['target'] ) : NULL;
		$instance['cloaking'] = ( ! empty( $new_instance['cloaking'] ) ) ? strip_tags( $new_instance['cloaking'] ) : NULL;
		$instance['width'] = ( ! empty( $new_instance['width'] ) ) ? strip_tags( $new_instance['width'] ) : NULL;
		$instance['height'] = ( ! empty( $new_instance['height'] ) ) ? strip_tags( $new_instance['height'] ) : NULL;
		return $instance;
	}
}