<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
?>
<?php #print $output; ?>
<?php #dpm($row); ?>
<ul>
<?php 
 foreach($row->field_field_teacher_position as $key => $position_array) {
   if ($position_array['raw']['taxonomy_term']->name == 'Учитель') {
     print '<li class="teacher">'.$position_array['raw']['taxonomy_term']->name.':'.views_embed_view('teacher_subjects', 'default', $row->uid).'</li>';
    }
   else {
     print '<li>'.$position_array['raw']['taxonomy_term']->name.'</li>';
    }
  }
?>
</ul>