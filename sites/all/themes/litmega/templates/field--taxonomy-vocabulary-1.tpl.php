<?php
// theme topic taxonomy display
?>

<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <div class="field-items"<?php print $content_attributes; ?>>
    <?php foreach ($items as $delta => $item) : ?>
      <div style="display:inline;" class="field-item <?php print $delta % 2 ? 'odd' : 'even'; ?>"<?php print $item_attributes[$delta]; ?>>
        <?php 
          print render($item);
          // Add comma if not last item
          if ($delta < (count($items) - 1)) {
            print ','; 
          }
        ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
