<?php
/**
 * @file
 * The primary PHP file for this theme.
**/


function school_menu_link__main_menu(array $variables) {
$element = $variables['element'];
#dpm($element);
$active_menu_path = menu_get_active_trail();
$active_menu_item = array_pop($active_menu_path);
$current_path = current_path();
$active_trail= menu_get_active_trail();
array_shift($active_trail);
#dpm($active_trail);
$detect = mobile_switch_mobile_detect();
#dpm($detect);
#$detect = mobile_detect_get_object();
#$is_mobile = $detect->isMobile();
#$is_tablet = $detect->isTablet();
#dpm($is_mobile);
#dpm($is_tablet);
$sub_menu = '';
$collapse = 'collapse';
$output ='';
$level_class = 'level-';
$level = 0;

 if (!$detect['ismobiledevice']) {
    
      $parents = token_menu_link_load_all_parents($element['#original_link']['mlid']);
#      dpm($parents);
      $level = count($parents);

    if ($element['#below']) {
       foreach ($active_trail as $key => $item) {
        if ($element['#title'] == $item['link_title']) {
         $collapse = 'collapse in';
         $element['#localized_options']['attributes']['aria-expanded'] = 'true';
         break;
        }
       }
#      $element['#href'] = '';
      $element['#title'] = $element['#title'].'<i class="arrow fa fa-list-ul" aria-hidden="true"></i>';
      $element['#localized_options']['html'] = TRUE;
      $element['#localized_options']['attributes']['data-target'] = '#'.$element['#original_link']['mlid'];
      $element['#localized_options']['attributes']['data-toggle'] = 'collapse';
      $element['#localized_options']['attributes']['data-parent'] = '#parent'.$element['#original_link']['plid'];
      $element['#localized_options']['attributes']['class'][] = 'list-group-parent-link';
      $element['#localized_options']['attributes']['class'][] = $level_class.$level;
      $element['#localized_options']['fragment'] = $element['#original_link']['mlid'];
      $element['#localized_options']['external'] = TRUE;
      $submenu = drupal_render($element['#below']);
      $submenu = '<div id="'.$element['#original_link']['mlid'].'" class="panel-collapse '.$collapse.'">'.$submenu.'</div>';
      $output = l($element['#title'], $element['#href'], $element['#localized_options']);
      $output = '<div class="panel">'.$output.$submenu.'</div>';
   }
   else {
#      $element['#href'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'list-group-child-link';
      $element['#localized_options']['attributes']['class'][] = $level_class.$level;
      $output = l($element['#title'], $element['#href'], $element['#localized_options']);
      $output = '<div class="panel">'.$output.'</div>';
   }
 }
 else {
    if ($element['#below']) {

        foreach ($active_trail as $key => $item) {
         if ($element['#title'] == $item['link_title']) {
/*         $collapse = 'collapse in';*/
         $element['#localized_options']['attributes']['aria-expanded'] = 'true';
         break;
         }
        }

      $sub_menu = drupal_render($element['#below']);
      $element['#href'] = '#';
      $element['#title'] = '<div class="link-title">'.$element['#title'].'</div><div class="parent-icon fa fa-angle-right"></div>'; 
      $element['#localized_options']['html'] = TRUE;
      $element['#localized_options']['fragment'] = 'parent'.$element['#original_link']['mlid'];;
      $element['#localized_options']['external'] = TRUE;
      $element['#localized_options']['attributes']['class'][] = 'list-group-item';
      $element['#localized_options']['attributes']['class'][] = 'parent-item';
      $element['#localized_options']['attributes']['data-toggle'] = 'collapse';
#      $element['#localized_options']['attributes']['role'] = 'button';
        if ($element['#original_link']['plid'] == 0) {
              $element['#localized_options']['attributes']['data-parent'] = '#js-bootstrap-offcanvas';
        }
        else {
              $element['#localized_options']['attributes']['data-parent'] = '#child'.$element['#original_link']['plid'];
        }
#      $element['#localized_options']['attributes']['aria-expanded'] = 'false';
#      $element['#localized_options']['attributes']['aria-haspopup'] = 'true';
#      $element['#attributes']['class'][] = 'dropdown';
#      $element['#attributes']['class'][] = 'dropdown-submenu';
      $output = l($element['#title'], $element['#href'], $element['#localized_options']);
      $output = $output.$sub_menu;
    }
    else {
      if ($element['#original_link']['plid'] == 0) {
            $element['#localized_options']['attributes']['data-parent'] = '#js-bootstrap-offcanvas';
      }
      else {
              $element['#localized_options']['attributes']['data-parent'] = '#child'.$element['#original_link']['plid'];
      }
      $element['#localized_options']['attributes']['class'][] = 'list-group-item';
      $element['#localized_options']['attributes']['class'][] = 'no-child';
      $output = l($element['#title'], $element['#href'], $element['#localized_options']);
#      $output = tributes']).$output;
    }
 }
    return $output;
}


function school_menu_tree__main_menu($variables) {
#dpm($variables);
$detect = mobile_switch_mobile_detect();
$active_trail= menu_get_active_trail();
#dpm($active_trail);
$first_active_trail = array_shift($active_trail);
$first_link = array_shift($variables['#tree']);
$plid = $first_link['#original_link']['plid'];
$mlid = $first_link['#original_link']['mlid'];
$collapse_in ='';

   if (!$detect['ismobiledevice']) {
     return '<div class="panel-group" id="parent'.$plid.'">'.$variables['tree'].'</div>';
   }
   else {
     if ($plid == 0) {
      return '<div class="list-group panel">'.$variables['tree'].'</div>';
     }
     else {
       foreach ($active_trail as $key => $item) {
         if ($item['plid'] == $plid) {
         $collapse_in = 'in';
         break;
         }
       } 
      return '<div class="collapse '.$collapse_in.' list-group-submenu" id="parent'.$plid.'"><div class="panel-group" id="child'.$plid.'"><div class="panel panel-default">'.$variables['tree'].'</div></div></div>';
     }
   }
}


function school_breadcrumb($variables) {
  // Use the Path Breadcrumbs theme function if it should be used instead.
  if (_bootstrap_use_path_breadcrumbs()) {
    return path_breadcrumbs_breadcrumb($variables);
  }

  $output = '';
  $breadcrumb = $variables['breadcrumb'];

  // Determine if we are to display the breadcrumb.
  $bootstrap_breadcrumb = bootstrap_setting('breadcrumb');
  if (($bootstrap_breadcrumb == 1 || ($bootstrap_breadcrumb == 2 && arg(0) == 'admin')) && !empty($breadcrumb)) {
    $output = theme('item_list', array(
      'attributes' => array(
        'class' => array('breadcrumb hidden-xs'),
      ),
      'items' => $breadcrumb,
      'type' => 'ol',
    ));
  }
  return $output;
}


function school_preprocess_panels_pane(&$vars) {
// get the subtype
$subtype = $vars['pane']->subtype;
$pane_type_array = array('news', 'events','node');
if (in_array($subtype, $pane_type_array))  $vars['title'] = '<div>'.$vars['title'].'</div><span class="pane-title-border"></span>';
/*
// Add the subtype to the panel theme suggestions list
$vars['theme_hook_suggestions'][] = 'panels_pane__'.$subtype;
*/
return $vars;
}


function school_status_messages($variables){
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
    $output .= "<div class=\"messages $type\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= reset($messages);
    }
    $output .= "</div>\n";
  }
  return $output;
}
