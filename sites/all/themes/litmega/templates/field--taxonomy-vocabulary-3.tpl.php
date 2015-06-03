<?php
// theme series taxonomy display
?>

<?php 
   global $series_text;
?>

<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php foreach ($items as $delta => $item): ?>
      <?php print $item_attributes[$delta]; ?>
       <hr height="5px" noshade />
       <p style="line-height: 16px; font-size: 15px;">
       <?php print "This article is part of the <b>" . render($item); ?></b> series. <?php print $series_text ?>
       </p>
       <hr height="5px" noshade />
    <?php endforeach; ?>
</div>
