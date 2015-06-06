<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php
  foreach ($fields as $id => $field):
    if ($id=="title") {
      $title = $field->content;
    } else if ($id=="name") {
      $name = $field->content;
    } else if ($id=="created") {
      $created = $field->content;
    } else if ($id=="field_story_image") {
      if ($field->content=='<div class="field-content"></div>') {
        $img = '<img src="http://litkicks.com/images/pv_good.gif" width="205" height="140" />';
      } else {
        $img = $field->content;
      }
    }
  endforeach;
?>
<div class="col-xs-12 col-sm-12 hidden-md hidden-lg hidden-xl">
  <div class="lklisting-pic"><?php print $img ?></div>
  <div class="lklisting-title"><?php print $title ?></div>
  <div class="lklisting-date"><?php print $created ?></div>
  <div class="lklisting-author"><?php print $name ?></div>
</div>
<div class="hidden-xs hidden-sm col-md-12 col-lg-12 col-xl-12">
  <table class="lklisting-table">
    <tr class="lklisting-tablerow">
      <td class="lklisting-pic">
        <?php print $img ?>
      </td>
      <td class="lklisting-desc">
        <div class="lklisting-title"><?php print $title ?></div>
        <div class="lklisting-date"><?php print $created ?></div>
        <div class="lklisting-author"><?php print $name ?></div>
      </td>
    </tr>
  </table>
</div>
