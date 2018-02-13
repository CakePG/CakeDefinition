<?php
namespace CakePG\CakeDefinition\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class DefinitionsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->addBehavior('CakePG/CakeDefinition.UpdateParentTimestamp', [
            'parentClass' => 'CakePG/CakeDefinition.DefinitionCategories',
            'foreignKey' => 'definition_category_id'
        ]);
        $this->addBehavior('CakePG/CakeDefinition.SortPriority');
        $this->belongsTo('DefinitionCategories', [
              'className' => 'CakePG/CakeDefinition.DefinitionCategories'
            ])
            ->setForeignKey('definition_category_id')
            ->setJoinType('INNER');

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
                    'term', 'description'
                ]
            ])
            ->value('definition_category_id')
            ->value('published');
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('definition_category_id')
            ->numeric('definition_category_id')
            ->requirePresence('definition_category_id', 'create')

            ->notEmpty('term')
            ->maxLength('term', 50, '50字以内で入力して下さい。')
            ->requirePresence('term', 'create')

            ->allowEmpty('description')

            ->notEmpty('published')
            ->add('published', 'inList', [
                'rule' => ['inList', [0, 1]]
            ])
            ->requirePresence('published', 'create');
    }
}
