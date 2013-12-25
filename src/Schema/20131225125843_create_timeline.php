<?php

use Phinx\Migration\AbstractMigration;

class CreateTimeline extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('timeline');
        $table->addColumn('date', 'datetime')
              ->addColumn('title', 'text')
              ->addColumn('description', 'text')
              ->addColumn('photo', 'text')
              ->create();
    }
}