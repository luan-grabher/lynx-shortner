<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
    protected $signature = 'user:create {name} {email} {password}';

    protected $description = 'Create a new user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = bcrypt($this->argument('password'));

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $this->info('User created successfully!');
    }
}
