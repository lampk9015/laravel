<?php

namespace Database\Seeders;

use App\Domains\Task\Models\Task;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class TaskSeeder.
 */
class TaskSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->truncate('announcements');

        if (app()->environment(['local', 'testing'])) {
            Task::factory(24)->create();
        }

        $this->enableForeignKeys();
    }
}
