<?php

namespace North\App\Blunt;

use North\App\Blunt\Blunt_Box as Blunt_Box;

class Blunt{

    /**
     * Construct a new Blunt
     *
     * @since	1.0.0
     */
    public function __construct()
    {

    }


    public static function returnView($filepath, $data)
    {

    return self::generateHTML($filepath, $data);

    }

  public static function showView($filepath, $data)
  {

    echo self::generateHTML($filepath, $data);

  }

  // private function generateHTML($filepath, $data){
  //   ob_start();
  //   get_template_part($filepath);
  //   $content = ob_get_contents();
  //   ob_end_clean();
  //   $trigger = true;
  //   while($trigger){
  //     $tmp = getStringpart($content, '{{', '}}');
  //     if($tmp){
  //       if(isset($data[$tmp])){
  //         $replace = $data[$tmp];
  //       }else{
  //         $replace = __(sprintf('No %s param was declared.', $tmp), 'nu_food');
  //       }
  //       $content = str_replace( '{{' . $tmp . '}}', $replace, $content );
  //     }else{
  //       break;
  //     }
  //   }
  //   return $content;
  // }

  private function generateHTML($filepath, $data){
    foreach ($data as $key => $item) {
      ${$key} = $item;
    }
    ob_start();
    include( locate_template( $filepath . '.php', false, false ) );
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
  }

  /**
   * Function for adding custom fields
   *
   * @param     int             $id              field id
   * @param     string          $title           field title
   * @param     (array|string)  $screen          the screen or screens on which to show the box
   * @param     string          $context         the context within the screen where the boxes should display
   * @param     string          $priority        the priority within the context where the boxes should show ('high', 'low')
   * @param     string          $callback_args   data that should be set as the $args property of the box array
   *
   * @return object
   *
   * @since 1.0.0
   *
  */
  public static function box( $id = null , $title = null , $screen = null , $context = null, $priority = null , $callback_args = null  )
  {
       return new Blunt_Box( $id , $title , $screen , $context , $priority , $callback_args );
  }


}
