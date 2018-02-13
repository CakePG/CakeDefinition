<?php
namespace CakePG\CakeDefinition\Controller\Admin;

use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\Event\Event;
use CakePG\CakeDefinition\Controller\AppController;

class DefinitionCategoriesController extends AppController
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
        $this->set('limit', Configure::read('CakeDefinition.category.limit'));
        $this->set('fixed', Configure::read('CakeDefinition.category.fixed'));
    }

    public function index()
    {
        $definitionCategories = $this->paginate($this->DefinitionCategories, [
            'order' => ['priority' => 'asc'],
            'finder' => [
                'search' => ['search' => $this->request->query]
            ]
        ]);
        $this->set('publishStatuses', Configure::read('CakeDefinition.publish_statuses'));
        $this->set(compact('definitionCategories'));
        $this->set('_serialize', ['definitionCategories']);
    }

    public function view($id = null)
    {
        $definitionCategory = $this->DefinitionCategories->get($id);
        $this->set(compact('definitionCategory'));
        $this->set('_serialize', ['definitionCategory']);
    }

    public function add()
    {
        // 登録制限
        if (Configure::read('CakeDefinition.category.fixed') || Configure::read('CakeDefinition.category.limit') <= $this->DefinitionCategories->find('all')->count()) {
            $this->Flash->error(__d('CakeDefinition', 'Definition Category').'はこれ以上登録できません');
            return $this->redirect(['action' => 'index']+$this->request->query());
        }
        $definitionCategory = $this->DefinitionCategories->newEntity();
        if ($this->request->is('post')) {
            $priority = $this->DefinitionCategories->find('all')->count();
            $definitionCategory = $this->DefinitionCategories->patchEntity($definitionCategory, $this->request->data + ['priority' => $priority]);
            if ($this->DefinitionCategories->save($definitionCategory)) {
                // ソート処理
                $orders = array_values($this->DefinitionCategories->find('list', ['valueField' => 'id', 'order' => ['priority' => 'asc']])->toArray());
                $this->DefinitionCategories->sortPriority($orders);
                $this->Flash->success(__d('CakeDefinition', 'Definition Category').'を登録しました');
                return $this->redirect(['action' => 'view', $definitionCategory->id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeDefinition', 'Definition Category').'の登録に失敗しました。もう一度お試しください');
        }
        $this->set(compact('definitionCategory'));
        $this->set('_serialize', ['definitionCategory']);
    }

    public function edit($id = null)
    {
        // 固定
        if (Configure::read('CakeDefinition.category.fixed')) {
            $this->Flash->error(__d('CakeDefinition', 'Definition Category').'は固定です');
            return $this->redirect(['action' => 'index']+$this->request->query());
        }
        $definitionCategory = $this->DefinitionCategories->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $definitionCategory = $this->DefinitionCategories->patchEntity($definitionCategory, $this->request->data);
            if ($this->DefinitionCategories->save($definitionCategory)) {
                $this->Flash->success(__d('CakeDefinition', 'Definition Category').'を編集しました');
                return $this->redirect(['action' => 'view', $id]+$this->request->query());
            }
            $this->Flash->error(__d('CakeDefinition', 'Definition Category').'の編集に失敗しました。もう一度お試しください');
        }
        $this->set(compact('definitionCategory'));
        $this->set('_serialize', ['definitionCategory']);
    }

    public function delete($id = null)
    {
        // 固定
        if (Configure::read('CakeDefinition.category.fixed')) {
            $this->Flash->error(__d('CakeDefinition', 'Definition Category').'は固定です');
            return $this->redirect(['action' => 'index']+$this->request->query());
        }
        $this->request->allowMethod(['post', 'delete']);
        $definitionCategory = $this->DefinitionCategories->get($id);
        try {
          if ($this->DefinitionCategories->delete($definitionCategory)) {
              // ソート処理
              $orders = array_values($this->DefinitionCategories->find('list', ['valueField' => 'id', 'order' => ['priority' => 'asc']])->toArray());
              $this->DefinitionCategories->sortPriority($orders);
              $this->Flash->success(__d('CakeDefinition', 'Definition Category').'を削除しました');
          } else {
              $this->Flash->error(__d('CakeDefinition', 'Definition Category').'の削除に失敗しました。もう一度お試しください');
          }
        } catch (\Exception $e) {
          if (strpos($e->getMessage(), '1451 Cannot delete or update a parent row') !== false) {
            $this->Flash->error(__d('CakeDefinition', 'Definition Category').'に'.__d('CakeDefinition', 'Definition').'が存在するため削除できません');
          } else {
            $this->Flash->error("不明なエラーが発生しました");
          }
        }
        return $this->redirect(['action' => 'index']+$this->request->query());
    }

    // 並び替え
    public function sort()
    {
        // 固定
        if (Configure::read('CakeDefinition.category.fixed')) {
            $this->Flash->error(__d('CakeDefinition', 'Definition Category').'は固定です');
            return $this->redirect(['action' => 'index']+$this->request->query());
        }
        $definitionCategories = $this->DefinitionCategories->find('all', ['order' => ['priority' => 'asc']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orders = explode(',',$this->request->data['orders']);
            if ($this->DefinitionCategories->sortPriority($orders)) {
                $this->Flash->success(__d('CakeDefinition', 'Definition Category').'の順序を変更しました');
                return $this->redirect(['action' => 'index']+$this->request->query());
            } else {
                $this->Flash->error(__d('CakeDefinition', 'Definition Category').'の順序の変更に失敗しました。もう一度お試しください');
            }
        }
        $this->set(compact('definitionCategories'));
        $this->set('_serialize', ['definitionCategories']);
    }
}
