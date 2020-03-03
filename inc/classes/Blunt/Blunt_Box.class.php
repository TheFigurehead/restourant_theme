<?php

namespace North\App\Blunt;

class Blunt_Box
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

            add_meta_box($this->id, $this->title, [ $this ,  'callback_rage' ], $this->screen, $this->context, $this->priority );

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
     * Meta box callback
     *
     * @param $post
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function callback_rage( $post )
    {
        $blunt_id = $this->get_blunt_ID();

        $blunt_fields = $this->fields;

        // Nonce field to validate form request came from current site
        wp_nonce_field( basename( __FILE__ ), $blunt_id . '_noncename' );

        // Get the location data if it's already been entered
        $field = get_post_meta( $post->ID, $blunt_id . '_field' , true );
        ?>

        <div style="border: 1px solid slategrey; padding: 10px;">
                    <input type='text' size='100' id='<?php echo $blunt_id . '_field';?>'
                     name='<?php echo $blunt_id . '_field'; ?>' value='<?php echo urlencode(\wp_json_encode( array('a' => 'lol'))); ?>'/>
              </div>
              <?php echo json_encode(array('a' => 'lol'), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>
              <pre>
                <?php var_dump($field); ?>
              </pre>
              ';
        
        <?php


        self::fieldRender( $blunt_fields );

        self::printAll($blunt_fields);

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
        $events_meta[ $blunt_id . '_field'] =  $_POST[ $blunt_id . '_field'] ;

        // Cycle through the $events_meta array.
        // Note, in this example we just have one item, but this is helpful if you have multiple.
        foreach ( $events_meta as $key => $value ) :
            $value = json_decode(urldecode($value), true);
            
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
     * @return Blunt_Box
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

    /**
     * Recursively output all array
     *
     * @param $array
     * @param $divider
     */
    public static function printAll( $array , $divider  = 1 ) {

        if ( $divider == 1 ) echo "<pre>";    // HTML Only

        if ( is_array( $array ) )
        {
            foreach( $array as $k => $v){

                for ( $i = 0 ; $i < $divider ; $i++){
                    echo "\t";
                }
                if (is_array( $v )){

                    echo $k.PHP_EOL;

                    self::printAll( $v,  $divider +1);

                } else {

                    if( $k == 'type') {

                        echo $k . "\t" . ' Type of field: ' . $v . PHP_EOL; //field type value

                    }
                    elseif( !is_array( $v ) && $k == 2 ){

                        echo $k . "\t" .  'Repeater Type of field: ' . $v . PHP_EOL; //value

                    }else {

                        echo $k . "\t" . $v . PHP_EOL; //value

                    }
                }
            }
        }

        if ( $divider == 1 ) echo "</pre>";   // HTML Only
    }

    /**
     * @param $array
     * @param int $divider
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function fieldRender( $array, $divider  = 1 ){

        //if ( $divider == 1 ) echo "<pre>";    // HTML Only

        if ( is_array( $array ) )
        {
            foreach( $array as $k => $v){

                for ( $i = 0 ; $i < $divider ; $i++){
//                    echo "span";
                }
                if (is_array( $v )){

                    //cho $k.PHP_EOL;

                    self::fieldRender( $v,  $divider +1);

                } else {

                    if( $k == 'id') {
                        $id = $v;
                    }

                    if( $k == 'type') {

                        if( $v == 'text') {

                            echo 'Norm Field
                                <div style="border: 1px solid slategrey; padding: 10px; margin-left: '. $divider .'0px;">
                                    <input type="text" id= "' . $id . '_field" name="_field" value="' . $v  . '" size="25" />
                                </div>';
                        }
                        if( $v == 'textarea') {

                            echo 'Norm Field
                                <div style="border: 1px solid slategrey; padding: 10px; margin-left: '. $divider .'0px;">
                                    <textarea id="' . $id . '">' . $v . '</textarea>
                                </div>';
                        }

                    }
                    elseif( !is_array( $v ) && $k == 2 ){

                        if( $v == 'text') {

                            echo 'Repeater Type of field
                                <div style="border: 1px solid slategrey; padding: 10px; margin-left: '. $divider .'0px;">
                                    <input type="text" id= "' . $id . '_field" name="_field" value="' . $v  . '" size="25" />
                                </div>';
                        }
                        if( $v == 'textarea') {

                            echo 'Repeater Type of field
                                <div style="border: 1px solid slategrey; padding: 10px; margin-left: '. $divider .'0px;">
                                    <textarea id="' . $id . '">' . $v . '</textarea>
                                </div>';
                        }

                    }

                }
            }
        }

        //if ( $divider == 1 ) echo "</pre>";   // HTML Only
    }

}