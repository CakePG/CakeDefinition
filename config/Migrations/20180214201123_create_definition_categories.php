<?php
use Migrations\AbstractMigration;

class CreateDefinitionCategories extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('definition_categories');
        $table->addIndex('published');
        $table->addColumn('name', 'string', [
                'null' => false,
              ])
              ->addColumn('published', 'boolean', [
                'default' => false,
                'null' => false,
              ])
              ->addColumn('priority', 'integer', [
                'default' => 0,
                'null' => false,
              ])
              ->addColumn('created', 'datetime', [
                'null' => false,
              ])
              ->addColumn('modified', 'datetime', [
                'null' => false,
              ])
              ->create();
    }
}
