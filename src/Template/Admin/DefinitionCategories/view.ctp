<?php
  $this->layout = 'admin';
  $this->assign('title', __d('CakeDefinition', 'Definition Category').'詳細 - '.__d('CakeDefinition', 'Website Admin Title').' | '.__d('CakeDefinition', 'Website Title'));
  $this->assign('keywords', '');
  $this->assign('description', '');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?= $dashboardPath ?>"><i class="fa fa-home" aria-hidden="true"></i><?= __d('CakeDefinition', 'Dashboard') ?></a></li>
  <li class="breadcrumb-item"><?= $this->Html->link(__d('CakeDefinition', 'Definition Category').'一覧', ['action' => 'index']+$this->request->query) ?></li>
  <li class="breadcrumb-item active" aria-current="page"><?= __d('CakeDefinition', 'Definition Category') ?>詳細</li>
</ol>

<div class="container">
  <div class="row align-items-end mb-2">
    <div class="col-md">
      <h2><?= __d('CakeDefinition', 'Definition Category') ?>詳細<hr class="d-none d-md-block"></h2>
    </div>
    <div class="col-md-auto">
      <nav class="nav nav-pills nav-fill">
        <?php if (!$fixed): ?>
          <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>編集', ['action' => 'edit', $definitionCategory->id]+$this->request->query, ['class' => 'btn btn-success', 'escape' => false]) ?>
          <?= $this->Form->postLink('<i class="fa fa-trash" aria-hidden="true"></i>削除', ['action' => 'delete', $definitionCategory->id]+$this->request->query, ['class' => 'btn btn-danger', 'escape' => false, 'confirm' => '『'.$definitionCategory->name.'』を本当に削除しますか？']) ?>
        <?php endif; ?>
      </nav>
    </div>
  </div>

  <div class="card admin">
    <div class="card-header">
      <nav class="nav nav-pills nav-fill">
        <?= $this->Html->link('<i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ', ['action' => 'index']+$this->request->query, ['class' => 'btn btn-sm btn-light', 'escape' => false]) ?>
      </nav>
    </div>
    <div class="card-body">
      <dl>
        <?php if (!$fixed): ?>
          <dt>公開</dt>
          <dd><?= $definitionCategory->published_msg ?></dd>
        <?php endif; ?>

        <dt>名前</dt>
        <dd><?= h($definitionCategory->name) ?></dd>
      </dl>

      <hr class="mb-2">
      <dl>
        <dt>作成日</dt>
        <dd><?= h($definitionCategory->created) ?></dd>

        <dt>更新日</dt>
        <dd><?= h($definitionCategory->modified) ?></dd>
      </dl>
    </div>
  </div>
</div>
