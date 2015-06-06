<?php
// primary article (story) node template for litkicks
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php
  $author = $node->name;
  $createdate = format_date($node->created, 'custom', "F jS, Y");
  if (empty($node->field_story_image)) {
    $img = '<img src="http://litkicks.com/images/pv_good.gif" width="190" height="120" />';
  } else {
    $img = '<img src="http://litkicks.com/sites/default/files/' . $node->field_story_image['und'][0]['filename'] . '" />';
  }
  ?>

  <div class="col-xs-12 col-sm-12 hidden-md hidden-lg hidden-xl lklisting-entry">
    <div class="lklisting-title"><?php print $title ?></div>
    <div class="lklisting-pic"><?php print $img ?></div>
    <div class="lklisting-date"><?php print $createdate ?></div>
    <div class="lklisting-author">by <?php print $author ?></div>
  </div>
  <div class="hidden-xs hidden-sm col-md-12 col-lg-12 col-xl-12 lklisting-entry">
    <table>
      <tr>
        <td class="lklisting-pic">
          <?php print $img ?>
        </td>
        <td class="lklisting-desc">
          <div class="lklisting-title"><?php print $title ?></div>
          <div class="lklisting-date"><?php print $createdate ?></div>
          <div class="lklisting-author">by <?php print $name ?></div>
        </td>
      </tr>
    </table>
  </div>
</div>
