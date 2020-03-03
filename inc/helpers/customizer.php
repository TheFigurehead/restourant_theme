<?php
function nu_get_custom_logo($theme_mod){
  return sprintf('<img src="%s" alt="logo" />', get_theme_mod($theme_mod) );
}
