<?php

namespace App\Providers;

use App\Models\User;
use App\Notifications\TelescopeEntryNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\IncomingExceptionEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;
use Notification;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Telescope::night();

        $this->hideSensitiveRequestDetails();

        Telescope::tag(function (IncomingEntry $entry) {
            if (
                $entry->type === EntryType::CLIENT_REQUEST &&
                Str::contains($entry->content['uri'], 'https://sft.bics.com/api')
            ) {
                return ['bics'];
            }
        });

        Telescope::filter(function (IncomingEntry $entry) {
            return $this->app->environment('local') ||
                    $entry->isReportableException() ||
                    $entry->isFailedRequest() ||
                    $entry->isFailedJob() ||
                    $entry->isScheduledTask() ||
                    $entry->hasMonitoredTag();
        });

        Telescope::afterStoring(function (array $entries) {
            foreach ($entries as $entry) {
                if ($entry instanceof IncomingExceptionEntry) {
                    Notification::route('mail', 'support@speakeasytelecom.com')
                        ->notify(new TelescopeEntryNotification($entry, url("/telescope/exceptions/{$entry->uuid}")));
                }
            }
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment('local')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', fn (User $user) => $user->admin());
    }
}
