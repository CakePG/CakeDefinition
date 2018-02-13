<?php
use Migrations\AbstractMigration;

class CreateDefinitions extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('definitions');
        $table->addIndex('published');
        $table->addColumn('definition_category_id', 'integer', [
                'null' => false,
              ])
              ->addColumn('term', 'string', [
                'null' => false,
              ])
              ->addColumn('description', 'text', [
                'default' => null,
                'null' => true,
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
              ->addForeignKey('definition_category_id', 'definition_categories', 'id', ['delete'=> 'RESTRICT', 'update'=> 'CASCADE'])
              ->create();
    }
}
