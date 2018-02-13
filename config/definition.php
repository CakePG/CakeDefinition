<?php
use Cake\Core\Configure;

$config = [
  'CakeDefinition' => [
    'dashboard_path' => '/admin',
    'category' => [
      'limit' => 5,
      'fixed' => false
    ],
    'definition' => [
      'limit' => 20
    ]
  ]
];

return $config;
