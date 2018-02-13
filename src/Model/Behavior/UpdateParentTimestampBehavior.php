<?php
namespace CakePG\CakeDefinition\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Modified 2017.11.24
 */
class UpdateParentTimestampBehavior extends Behavior
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->parentClass = $config['parentClass'];
        $this->foreignKey = $config['foreignKey'];
    }

    public function afterSave($event, $entity, $options)
    {
        $parentTable = TableRegistry::get($this->parentClass);
        $parent = $parentTable->get($entity->{$this->foreignKey});
        if ($parent) {
          $parentTable->touch($parent);
          $parentTable->save($parent);
        }
    }
}
