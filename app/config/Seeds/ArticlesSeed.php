<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Articles seed.
 */
class ArticlesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'title'    => 'First article',
                'body' => 'This is first article',
                'user_id'     => 1,
                'created_at' => '2024-02-02 02:02:02',
                'updated_at' => '2024-02-02 02:02:02',
            ],
            [
                'title'    => 'Second article',
                'body' => 'This is Second article',
                'user_id'     => 2,
                'created_at' => '2024-02-02 02:02:02',
                'updated_at' => '2024-02-02 02:02:02',
            ]
        ];

        $table = $this->table('articles');
        $table->insert($data)->save();
    }
}
