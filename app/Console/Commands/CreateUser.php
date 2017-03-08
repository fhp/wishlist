<?php

namespace Wenslijst\Console\Commands;

use Illuminate\Console\Command;
use Wenslijst\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {username} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $user = new User();
        $user->name = $this->argument("username");
        $user->email = $this->argument("email");
        $user->password = \Hash::make($this->argument("password"));
        $user->save();
    }
}
