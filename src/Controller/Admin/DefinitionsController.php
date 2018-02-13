<?php
namespace CakePG\CakeDefinition\Controller\Admin;

use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\Event\Event;
use CakePG\CakeDefinition\Controller\AppController;

class DefinitionsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->set('limit', Configure::read('CakeDefinition.definition.limit'));
    }

    public function index($categoryId)
    {
        $this->loadModel('CakeDefinition.DefinitionCategories');
        $definitionCategory = $this->DefinitionCategories->get($categoryId);

        $definitions = $this->paginate($this->Definitions, [
            'contain' => ['DefinitionCategories'],
            'order' => ['priority' => 'asc'],
            'conditions' => ['definition_category_id' => $categoryId],
            'finder' => [
                'search' => ['search' => $this->request->query]
            ]
        ]);
        $this->set('publishStatuses', Configure::read('CakeDefinition.publish_statuses'));
        $this->set(compact('definitions', 'definitionCategory'));
        $this->set('_serialize', ['definitions']);
    }

    public function view($id = null)
    {
        $definition = $this->Definitions->get($id, ['contain' => ['DefinitionCategories']]);
        $this->set(compact('definition'));
        $this->set('_serialize', ['definition']);
    }

    public function add($categoryId)
    {
      // 登録制限
        if (Configure::read('CakeDefinition.definition.limit') <= $this->Definitions->find('all', ['conditions' => ['definition_category_id' => $categoryId]])->count()) {
            $this->Flash->error(__d('CakeDefinition', 'Definition').'はこれ以上登録できません');
            return $this->redirect(['action' => 'index', $categoryId]+$this->request->query());
        }
        $this->loadModel('CakeDefinition.DefinitionCategories');
        $definitionCategory = $this->DefinitionCategories->get($categoryId);
        $definition = $this->Definitions->newEntity();
        if ($this->request->is('post')) {
            $priority = $this->Definitions->find('all', ['conditions' => ['definition_category_id' => $categoryId]])->count();
            $definition = $this->Definitions->patchEntity($definition, $this->request->data + ['priority' => $priority]);
            if ($this->Definitions->save($definition)) {
                // ソート処理
                $orders = array_values($this->Definitions->find('list', ['valueField' => 'id', 'conditions' => ['definition_category_id' => $categoryId], 'order' => ['priority' => 'asc']])->toArray());
                $this->Definitions->sortPriority($orders);
                $this->Flash->success(__d('CakeDefinition', 'Definition').'を登録しました');
                return $this->redirect(['action' => 'view', $definition->id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeDefinition', 'Definition').'の登録に失敗しました。もう一度お試しください');
        }
        $this->set(compact('definition', 'definitionCategory'));
        $this->set('_serialize', ['definition']);
    }

    public function edit($id = null)
    {
        $definition = $this->Definitions->get($id, ['contain' => ['DefinitionCategories']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $definition = $this->Definitions->patchEntity($definition, $this->request->data);
            if ($this->Definitions->save($definition)) {
                $this->Flash->success(__d('CakeDefinition', 'Definition').'を編集しました');
                return $this->redirect(['action' => 'view', $id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeDefinition', 'Definition').'の編集に失敗しました。もう一度お試しください');
        }
        $this->set('definitionCategories', $this->Definitions->DefinitionCategories->find('list', ['valueField' => 'name', 'order' => ['priority' => 'asc']]));
        $this->set(compact('definition'));
        $this->set('_serialize', ['definition']);
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $definition = $this->Definitions->get($id);
        $categoryId = $definition->definition_category_id;
        try {
          if ($this->Definitions->delete($definition)) {
              // ソート処理
              $orders = array_values($this->Definitions->find('list', ['valueField' => 'id', 'conditions' => ['definition_category_id' => $categoryId], 'order' => ['priority' => 'asc']])->toArray());
              $this->Definitions->sortPriority($orders);
              $this->Flash->success(__d('CakeDefinition', 'Definition').'を削除しました');
          } else {
              $this->Flash->error(__d('CakeDefinition', 'Definition').'の削除に失敗しました。もう一度お試しください');
          }
        } catch (\Exception $e) {
          $this->Flash->error("不明なエラーが発生しました");
        }
        return $this->redirect(['action' => 'index', $categoryId]+$this->request->query());
    }

    // 並び替え
    public function sort($categoryId)
    {
        $this->loadModel('CakeDefinition.DefinitionCategories');
        $definitionCategory = $this->DefinitionCategories->get($categoryId);

        $definitions = $this->Definitions->find('all', ['order' => ['priority' => 'asc'], 'conditions' => ['definition_category_id' => $categoryId]]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orders = explode(',',$this->request->data['orders']);
            if ($this->Definitions->sortPriority($orders)) {
                $this->Flash->success(__d('CakeDefinition', 'Definition').'の順序を変更しました');
                return $this->redirect(['action' => 'index', $categoryId]+$this->request->query());
            } else {
                $this->Flash->error(__d('CakeDefinition', 'Definition').'の順序の変更に失敗しました。もう一度お試しください');
            }
        }
        $this->set(compact('definitions', 'definitionCategory'));
        $this->set('_serialize', ['definitions']);
    }
}
