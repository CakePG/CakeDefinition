<?php
use Cake\Core\Configure;

return [
    Configure::write('CakeDefinition.publish_statuses', [
      '1' => '公開',
      '0' => '非公開'
    ])
];
