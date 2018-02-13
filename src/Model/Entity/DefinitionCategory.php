<?php
namespace CakePG\CakeDefinition\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;

class DefinitionCategory extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _getPublishedMsg()
    {
        $publishStatuses = Configure::read('CakeDefinition.publish_statuses');
        return $this->published ?
        '<span class="badge badge-success">'.$publishStatuses[$this->published].'</span>' :
        '<span class="badge badge-danger">'.$publishStatuses[$this->published].'</span>';
    }
}
