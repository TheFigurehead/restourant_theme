<?php

namespace North\App\Blunt;

class Blunt_Field
{
    /**
     * Blunt id
     *
     * @var int|null
     *
     * @since 1.0.0
     */
    public $id;

    /**
     *
     * @var null|array
     *
     */
    public $fields = array();

    /**
     * Class for adding custom fields
     *
     * @param     int             $id              field id
     * @param     string          $title           field title
     * @param     (array|string)  $screen          the screen or screens on which to show the box
     * @param     string          $context         the context within the screen where the boxes should display
     * @param     string          $priority        the priority within the context where the boxes should show ('high', 'low')
     * @param     string          $callback_args   data that should be set as the $args property of the box array
     *
     * @return void
     *
     * @since 1.0.0
     *
     */
    public function __construct( $id = null , $title = null , $screen = null , $context = null, $priority = null , $callback_args = null  )
    {
        $this->id = $id;
        $this->title = $title;

        $this->screen = $screen;
        $this->context = $context;
        $this->priority = $priority;
        $this->callback_args = $callback_args;


        add_action( 'add_meta_boxes', function () {

            add_meta_box($this->id, $this->title, [ $this ,  'callback' ], $this->screen, $this->context, $this->priority );

        });

        add_action( 'save_post',  [ $this, 'save_blunt_events_meta'], 1, 2  );


    }

    /**
     * Output the HTML for the metabox.
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function callback( $post )
    {

        $blunt_id = $this->get_blunt_ID();

        // Nonce field to validate form request came from current site
        wp_nonce_field( basename( __FILE__ ), $blunt_id . '_noncename' );

        // Get the location data if it's already been entered
        $field = get_post_meta( $post->ID, $blunt_id . '_field' , true );

        // Output the field
        echo '<label for="' . $blunt_id . '_field">' . __( "Description for this field", 'nu_food' ) . '</label> ';
        echo '<input type="text" id= "' . $blunt_id . '_field" name="' . $blunt_id . '_field" value="' . esc_textarea( $field , 'nu_food' )  . '" size="25" />';

    }


    /**
     * Save the metabox data
     *
     * @param 	int	     $post_id		ID of post type
     * @param 	object	 $post			Post object
     *
     * @return  void
     *
     * @since	1.0.0
     */
    public function save_blunt_events_meta( $post_id, $post )
    {

        $blunt_id = $this->get_blunt_ID();

        // Return if the user doesn't have edit permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }
        // Verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times.
        if ( ! isset( $_POST[ $blunt_id . '_field'] ) || ! wp_verify_nonce( $_POST[ $blunt_id . '_noncename' ], basename(__FILE__) ) ) {
            return $post_id;
        }

        // Now that we're authenticated, time to save the data.
        // This sanitizes the data from the field and saves it into an array $events_meta.
        $events_meta[ $blunt_id . '_field'] = esc_textarea( $_POST[ $blunt_id . '_field'] );

        // Cycle through the $events_meta array.
        // Note, in this example we just have one item, but this is helpful if you have multiple.
        foreach ( $events_meta as $key => $value ) :
            // Don't store custom data twice
            if ( 'revision' === $post->post_type ) {
                return;
            }
            if ( get_post_meta( $post_id, $key, false ) ) {
                // If the custom field already has a value, update it.
                update_post_meta( $post_id, $key, $value );
            } else {
                // If the custom field doesn't have a value, add it.
                add_post_meta( $post_id, $key, $value);
            }
            if ( ! $value ) {
                // Delete the meta key if there's no value
                delete_post_meta( $post_id, $key );
            }
        endforeach;
    }

    /**
     * @return int|null
     */
    public function get_blunt_ID() {
        return $this->id;
    }


    /**
     * @param null $id
     * @param null $title
     * @param null $type
     *
     * @return Blunt_Field
     *
     * @since 1.0.0
     */
    public function field( $id = null , $title = null , $type = null )
    {
        array_push( $this->fields,
            array(
                'id' => $id,
                'title' => $title,
                'type' => $type
            )
        );

        return $this;
    }

    /**
     * @param null $id
     * @param null $args
     * @return array
     */
    public function fields( $id = null , $args = null )
    {

        array_push( $this->fields , array( $id , $args ) );

    }

}