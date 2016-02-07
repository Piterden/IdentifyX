<?php
$xpdo_meta_map['idfxResource']= array (
  'package' => 'identifyx',
  'version' => '1.1',
  'extends' => 'modResource',
  'fields' => 
  array (
  ),
  'fieldMeta' => 
  array (
  ),
  'composites' => 
  array (
    'Likes' => 
    array (
      'class' => 'idfxUserLikes',
      'local' => 'id',
      'foreign' => 'res_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
