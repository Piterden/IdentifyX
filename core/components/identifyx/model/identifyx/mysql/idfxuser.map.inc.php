<?php
$xpdo_meta_map['idfxUser']= array (
  'package' => 'identifyx',
  'version' => '1.1',
  'extends' => 'modUser',
  'fields' => 
  array (
  ),
  'fieldMeta' => 
  array (
  ),
  'composites' => 
  array (
    'Pic' => 
    array (
      'class' => 'idfxUserPic',
      'local' => 'id',
      'foreign' => 'user_id',
      'cardinality' => 'one',
      'owner' => 'local',
    ),
    'Likes' => 
    array (
      'class' => 'idfxUserLikes',
      'local' => 'id',
      'foreign' => 'createdby',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Fingers' => 
    array (
      'class' => 'idfxUserData',
      'local' => 'id',
      'foreign' => 'user_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
