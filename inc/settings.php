<?php

  raintpl::configure("base_url", null );
  raintpl::configure("tpl_dir", "tpl/" ); // Tema klasörünün adı.
  raintpl::configure("cache_dir", "cache/" ); // Cachelerin saklanacağı klasörün adı
  raintpl::configure( 'black_list', array('_SESSION') );
  raintpl::configure( 'path_replace', true );
  raintpl::configure( 'path_replace_list', array('a', 'link', 'script', 'input'));
  raintpl::configure( 'php_enabled', true );

  $tpl = new RainTPL;
  $tpl->configure( 'tpl_ext', 'php' );


?>