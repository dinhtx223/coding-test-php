<?php
use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('email', 'string', ['limit' => 255])
              ->addColumn('password', 'string', ['limit' => 255])
              ->addColumn('token', 'string', ['null' => true])
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->create();
    }
}
