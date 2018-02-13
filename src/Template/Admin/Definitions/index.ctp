<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeDefinition', 'Definition').'一覧 - '.__d('CakeDefinition', 'Website Admin Title').' | '.__d('CakeDefinition', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeDefinition', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeDefinition', 'Definition Category').'一覧', ['controller' => 'definitionCategories', 'action' => 'index']) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeDefinition', 'Definition') ?>一覧</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= $definitionCategory->name ?> <?= __d('CakeDefinition', 'Definition') ?>一覧<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-th-list" aria-hidden="true"></i>'.__d('CakeDefinition', 'Definition Category').'一覧', ['controller' => 'definitionCategories', 'action' => 'index'], ['class' => 'btn btn-secondary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fa fa-sort-amount-asc" aria-hidden="true"></i>並び替え', ['action' => 'sort', $definitionCategory->id], ['class' => 'btn btn-warning', 'escape' => false]) ?>
        <?php if ($limit > $this->Paginator->counter("{{count}}")): ?>
          <?= $this->Html->link('<i class="fa fa-plus" aria-hidden="true"></i>新規登録', ['action' => 'add', $definitionCategory->id], ['class' => 'btn btn-success', 'escape' => false]) ?>
        <?php endif; ?>
      </nav>
    </div>
  </div>

  <?= $this->Form->create(null, ['valueSources' => 'query']); ?>
  <div class="row mb-2">
    <div class="col-md-4">
      <?= $this->Form->control('published', ['label'=>false, 'empty'=>'公開状況', 'options'=>$publishStatuses, 'type'=>'select', 'class'=>'form-control']); ?>
    </div>
    <div class="col-md">
      <?= $this->Form->control('q', ['label'=>false, 'class'=>'form-control', 'placeholder'=>'名前']); ?>
    </div>
    <div class="col-md-2 mt-2 mt-md-0 text-right">
      <?= $this->Form->button('<i class="fa fa-search" aria-hidden="true"></i> 検索', ['type' => 'submit', 'class'=>'btn btn-dark', 'escapeTitle'=>false]); ?>
      <?= $this->Html->link('<i class="fa fa-refresh" aria-hidden="true"></i>', ['action' => 'index', $definitionCategory->id], ['class'=>'btn btn-warning', 'escapeTitle'=>false]); ?>
    </div>
  </div>
  <?= $this->Form->end(); ?>

  <?php if ($limit): ?>
    <p><?= $limit ?>個まで登録が可能です。</p>
  <?php endif; ?>

  <table class="table admin">
    <thead>
      <tr>
        <th class="ids"><?= $this->Paginator->sort('published', '公開') ?></th>
        <th class="ids d-none d-md-table-cell"><?= $this->Paginator->sort('priority', '順番') ?></th>
        <th><?= $this->Paginator->sort('term', '項目名') ?></th>
        <th><?= $this->Paginator->sort('description', '内容') ?></th>
        <th class="actions">操作</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($definitions as $definition) : ?>
        <tr>
          <td class="ids"><?= $definition->published_msg ?></td>
          <td class="ids d-none d-md-table-cell"><?= h($definition->priority) ?></td>
          <td><?= mb_strimwidth(h($definition->term), 0, 20, "…", "UTF-8") ?></td>
          <td><?= mb_strimwidth(h($definition->description), 0, 60, "…", "UTF-8") ?></td>
          <td class="actions">
            <?= $this->Html->link('<i class="fa fa-eye" aria-hidden="true"></i>詳細', ['action' => 'view', $definition->id]+$this->request->query, ['escape' => false]) ?>
            <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>編集', ['action' => 'edit', $definition->id]+$this->request->query, ['escape' => false]) ?>
            <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $definition->id]+$this->request->query, ['escape' => false, 'confirm' => '『'.$definition->term.'』を本当に削除しますか？']) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?= $this->element('pagination') ?>

  <nav class="nav justify-content-center">
    <?= $this->Html->link('<i class="fa fa-angle-double-left" aria-hidden="true"></i>'.__d('CakeDefinition', 'Definition Category').'一覧へ戻る', ['controller' => 'definitionCategories', 'action' => 'index'], ['class' => 'btn btn-link mt-3', 'escape' => false]) ?>
  </nav>
</div>
