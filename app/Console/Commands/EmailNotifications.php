<?php

namespace App\Console\Commands;

use App\Mail\NotificationEndpoint50;
use App\Models\Endpoint;
use App\Models\MailNotifications;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmailNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();

        $users = $users->filter(function ($user) {
            return $user->settings()->where('name', 'allow_notification')->count();
        });

        foreach ($users as $user) {
            foreach ($user->settings->where('name', '!=', 'allow_notification') as $setting) {
                $endpoints = Endpoint::where('user_id', $user->id)->get();
                foreach ($endpoints as $endpoint) {
                    if ($setting->name == 'notify_when_50_remaining' && $endpoint->getUsagePercentage() < 50 && ! MailNotifications::where(['user_id' => $user->id, 'endpoint_id' => $endpoint->id, 'type' => 'notify_when_50_remaining'])->exists()) {
                        Mail::to($user)->send(new NotificationEndpoint50($endpoint));
                    }
                }
            }
        }

        return 0;
    }
}
