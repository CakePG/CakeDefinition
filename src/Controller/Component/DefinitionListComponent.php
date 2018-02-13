<?php
namespace CakePG\CakeDefinition\Controller\Component;

use Cake\Controller\Component;

class DefinitionListComponent extends Component
{

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->controler = $this->_registry->getController();
    }

    public function getDefinitionCategories()
    {
        $this->controler->loadModel('CakePG/CakeDefinition.DefinitionCategories');
        return $this->controler->DefinitionCategories->find('all' , [
            'conditions' => ['published' => true],
            'contain' => ['Definitions'=> function ($q) {
              return $q->where(['Definitions.published' => true])->order(['priority' => 'ASC']);
            }],
            'order' => ['priority' => 'asc']
        ]);
    }
}
