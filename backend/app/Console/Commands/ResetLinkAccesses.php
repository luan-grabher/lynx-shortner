<?php

namespace App\Console\Commands;

use App\Models\Link;
use Illuminate\Console\Command;

class ResetLinkAccesses extends Command
{
    protected $signature = 'links:reset-accesses';


    protected $description = 'Reset the number of accesses of all links';

    public function handle()
    {
        Link::query()->update(['access_count' => 0]);

        $this->info('Acessos dos links redefinidos com sucesso.');
    }
}
