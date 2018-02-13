<?php
namespace CakePG\CakeDefinition\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;
use Cake\Event\Event;

class AppController extends BaseController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->set('dashboardPath', Configure::read('CakeDefinition.dashboard_path'));
    }
}
