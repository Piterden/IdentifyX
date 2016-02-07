<?php
$xpdo_meta_map['idfxUserLikes']= array (
  'package' => 'identifyx',
  'version' => '1.1',
  'table' => 'ix_user_likes',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'finger' => NULL,
    'res_id' => NULL,
    'createdby' => 0,
    'createdon' => 0,
  ),
  'fieldMeta' => 
  array (
    'finger' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'attributes' => 'unsigned',
    ),
    'res_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'attributes' => 'unsigned',
    ),
    'createdby' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'attributes' => 'unsigned',
    ),
    'createdon' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'finger' => 
    array (
      'alias' => 'finger',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'finger' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'res_id' => 
    array (
      'alias' => 'res_id',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'res_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'CreatedBy' => 
    array (
      'class' => 'modUser',
      'local' => 'createdby',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Res' => 
    array (
      'class' => 'modResource',
      'local' => 'res_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Finger' => 
    array (
      'class' => 'idfxUserData',
      'local' => 'finger',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
