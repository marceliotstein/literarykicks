<article<?php print $attributes; ?>>
  <header>
    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
      <h3<?php print $title_attributes; ?>><?php //print $title ?></h3>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if (isset($unpublished)): ?>
      <em class="unpublished"><?php print $unpublished; ?></em>
    <?php endif; ?>
  </header>

  <footer class="comment-submitted">
   <?php
      print t('by !username on !datetime',
      array('!username' => $author, '!datetime' => '<time datetime="' . $datetime . '">' . $created . '</time>'));
    ?>
  </footer>

  <div<?php print $content_attributes; ?>>
    <?php
      hide($content['links']);
      $render_content = render($content);
      $clean_content = str_replace("(not verified)","",$render_content);
      //print render($content);
      print $clean_content;
    ?>
  </div>

  <?php if ($signature): ?>
    <div class="user-signature"><?php print $signature ?></div>
  <?php endif; ?>

  <?php if (!empty($content['links'])): ?>
    <nav class="links comment-links clearfix"><?php print render($content['links']); ?></nav>
  <?php endif; ?>

</article>
