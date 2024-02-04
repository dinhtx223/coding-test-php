<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
                'email'    => 'admin@admin.com',
                // 123456
                'password' => '$2y$10$hnbtgN/koVFPD5I.8l777.ZhHIHhO6VUygGdxGnufAAB7z/GdO8ZG',
                'created_at' => '2024-02-02 02:02:02',
                'updated_at' => '2024-02-02 02:02:02',
            ],
            [
                'email'    => 'user@user.com',
                // 123456
                'password' => '$2y$10$hnbtgN/koVFPD5I.8l777.ZhHIHhO6VUygGdxGnufAAB7z/GdO8ZG',
                'created_at' => '2024-02-02 02:02:02',
                'updated_at' => '2024-02-02 02:02:02',
            ]
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
