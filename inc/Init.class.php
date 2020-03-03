<?php

namespace North;

use North\App\Setup as Setup;
use North\App\Admin as Admin;
use North\App\Breadcrumbs as Breadcrumbs;
use North\App\Enqueue as Enqueue;
use North\App\Blunt\Blunt as Blunt;

class Init{
  public function run(){
    $this->setup = new Setup();
    $this->admin = new Admin();
    $this->breadcrumbs = new Breadcrumbs();
    $this->enqueue = new Enqueue();
    $this->blunt = new Blunt();

    $this->blunt->box(  'blunt_sectionid', 'My First Blunt Meta Box',  'page', 'side', 'high'  );

    // __( $$$$$$$$ , "with textdomain ") !!!!!!!!!!
    Blunt::box('my_blunt_textarea', 'My Blunt Meta Box',  'post', 'normal', 'high' )
    ->field('blunt_field_title', 'Many text fields title', 'text')
    ->field('blunt_field_textarea', 'My Textarea', 'textarea')
    ->field('blunt_field_rep', 'My Mega Rep',
        array(
            'blunt_field_rep_1',
            'My Mega Rep d1' ,
            array(
                'blunt_field_rep_1_2',
                'My Mega Rep d2' ,
                array(
                    'blunt_field_rep_1_3',
                    'My Mega Rep d3' ,
                    'textarea'
                ),
                'blunt_field_rep_2_2',
                'My Mega Rep d2_2' ,
                array(
                    'blunt_field_rep_2_3',
                    'My Mega Rep d3_3' ,
                    'text'
                )

            )
        )
    );

  }
}
