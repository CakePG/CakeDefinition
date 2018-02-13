<?php
namespace CakePG\CakeDefinition\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class DefinitionCategoriesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->addBehavior('CakePG/CakeDefinition.SortPriority');
        $this->hasMany('Definitions', [
              'className' => 'CakePG/CakeDefinition.Definitions'
            ])
            ->setForeignKey('definition_category_id')
            ->setDependent(false);

        // search
        $this->addBehavior('Search.Search');
        $this->searchManager()
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => [
                    'name'
                ]
            ])
            ->value('published');
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('name')
            ->maxLength('name', 50, '50字以内で入力して下さい。')
            ->requirePresence('name', 'create')

            ->notEmpty('published')
            ->add('published', 'inList', [
                'rule' => ['inList', [0, 1]]
            ])
            ->requirePresence('published', 'create');
    }
}
