<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeDefinition', 'Definition').'詳細 - '.__d('CakeDefinition', 'Website Admin Title').' | '.__d('CakeDefinition', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeDefinition', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeDefinition', 'Definition Category').'一覧', ['controller' => 'definitionCategories', 'action' => 'index']) ?></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeDefinition', 'Definition').'一覧', ['action' => 'index', $definition->definition_category_id]+$this->request->query) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeDefinition', 'Definition') ?>詳細</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeDefinition', 'Definition') ?>詳細<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>編集', ['action' => 'edit', $definition->id]+$this->request->query, ['class' => 'btn btn-success', 'escape' => false]) ?>
        <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $definition->id]+$this->request->query, ['class' => 'btn btn-danger', 'escape' => false, 'confirm' => '『'.$definition->term.'』を本当に削除しますか？']) ?>
      </nav>
    </div>
  </div>

  <div class="card admin">
    <div class="card-header">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ', ['action' => 'index', $definition->definition_category_id]+$this->request->query, ['class' => 'btn btn-sm btn-light', 'escape' => false]) ?>
      </nav>
    </div>
    <div class="card-body">
      <dl>
        <dt>公開</dt>
        <dd><?= $definition->published_msg ?></dd>

        <dt>カテゴリ</dt>
        <dd><?= h($definition->definition_category->name) ?></dd>

        <dt>項目名</dt>
        <dd><?= nl2br(h($definition->term)) ?></dd>

        <dt>内容</dt>
        <dd><?= nl2br(h($definition->description)) ?></dd>

        <dt>作成日</dt>
        <dd><?= h($definition->created) ?></dd>

        <dt>更新日</dt>
        <dd><?= h($definition->modified) ?></dd>
      </dl>
    </div>
  </div>
</div>
