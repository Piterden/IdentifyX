<?php
$xpdo_meta_map['idfxUserIps']= array (
  'package' => 'identifyx',
  'version' => '1.1',
  'table' => 'ix_user_ips',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'ip' => '',
    'user_id' => 0,
    'finger' => 0,
  ),
  'fieldMeta' => 
  array (
    'ip' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'default' => 0,
      'attributes' => 'unsigned',
    ),
    'finger' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'attributes' => 'unsigned',
    ),
  ),
  'indexes' => 
  array (
    'user_ip' => 
    array (
      'alias' => 'user_ip',
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
        'ip' => 
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
    'User' => 
    array (
      'class' => 'modUser',
      'local' => 'ip',
      'foreign' => 'id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
  ),
);
