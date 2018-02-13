<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeDefinition', 'Definition').'編集 - '.__d('CakeDefinition', 'Website Admin Title').' | '.__d('CakeDefinition', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeDefinition', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeDefinition', 'Definition Category').'一覧', ['controller' => 'definitionCategories', 'action' => 'index']) ?></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeDefinition', 'Definition').'一覧', ['action' => 'index', $definition->definition_category_id]+$this->request->query) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeDefinition', 'Definition') ?>編集</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeDefinition', 'Definition') ?>編集<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $definition->id]+$this->request->query, ['class' => 'btn btn-danger', 'escape' => false, 'confirm' => '『'.$definition->term.'』を本当に削除しますか？']) ?>
      </nav>
    </div>
  </div>

  <div class="card admin">
    <div class="card-header">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ', ['action' => 'index', $definition->definition_category_id]+$this->request->query, ['class' => 'btn btn-sm btn-light', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fa fa-angle-left" aria-hidden="true"></i>詳細へ', ['action' => 'view', $definition->id]+$this->request->query, ['class' => 'btn btn-sm btn-light', 'escape' => false]) ?>
      </nav>
    </div>
    <div class="card-body">
      <?= $this->Form->create($definition, ['templates' => 'app_form_bootstrap']); ?>
      <?php
        echo $this->Form->control('definition_category_id', ['type' => 'hidden']);
        echo $this->Form->control('published', ['type' => 'checkbox', 'default' => true, 'label' => '公開する']);
        echo $this->Form->control('term',['label' => '項目名', 'class' => 'form-control', 'type' => 'textarea', 'rows' => 2]);
        echo $this->Form->control('description',['label' => '内容', 'class' => 'form-control', 'rows' => 4]);
      ?>
      <?= $this->Form->submit('保存', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
