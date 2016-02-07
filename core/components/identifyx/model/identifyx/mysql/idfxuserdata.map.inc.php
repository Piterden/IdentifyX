<?php
$xpdo_meta_map['idfxUserData']= array (
  'package' => 'identifyx',
  'version' => '1.1',
  'table' => 'ix_user_finger',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'fingerprint' => '',
    'votes' => 0,
    'user_id' => 0,
  ),
  'fieldMeta' => 
  array (
    'fingerprint' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '50',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'votes' => 
    array (
      'dbtype' => 'int',
      'precision' => '5',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'default' => 0,
      'attributes' => 'unsigned',
    ),
  ),
  'indexes' => 
  array (
    'user_id' => 
    array (
      'alias' => 'user_id',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'user_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'votes' => 
    array (
      'alias' => 'votes',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'votes' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'fp_owner' => 
    array (
      'alias' => 'fp_owner',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'user_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'fingerprint' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Ips' => 
    array (
      'class' => 'idfxUserIps',
      'local' => 'id',
      'foreign' => 'finger',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Likes' => 
    array (
      'class' => 'idfxUserLikes',
      'local' => 'id',
      'foreign' => 'finger',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'User' => 
    array (
      'class' => 'modUser',
      'local' => 'user_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
