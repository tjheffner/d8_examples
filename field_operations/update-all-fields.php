<?php

/**
 * Sets all non-title fields to optional.
 */
function hook_update_N() {
  // Services we need.
  $entityFieldManager = \Drupal::service('entity_field.manager');
  $config = \Drupal::service('config.factory');

  // Get all node fields.
  $fields = $entityFieldManager->getFieldMap();
  $fields = $fields['node'];
  $base_fields = $entityFieldManager->getBaseFieldDefinitions('node');
 
  // Pop off the entity key & generic fields (nid, uuid, revision_log, etc).
  $fields = array_diff_key($fields, $base_fields);

  // getFieldMap returns field names as the array key.
  $keys = array_keys($fields);

  // Loop through all fields, plus all bundles that a field is found on.
  foreach ($keys as $key => $value) {
    $field_name = $keys[$key];
    $bundles = $fields[$value]['bundles'];

    // In this example, we change every custom node field instance to be optional.
    // Replace this with whatever specific code you need to change all field instances.
    foreach ($bundles as $bundle) {
      $config->getEditable("field.field.node.$bundle.$field_name")->set('required', FALSE)->save();
    }
  }

}
