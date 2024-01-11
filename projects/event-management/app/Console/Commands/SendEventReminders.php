<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminderNotifiction;
use Illuminate\Support\Str;
use Illuminate\Console\Command;


class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends reminder notification to all attendees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('ateendees.user')
            ->whereBetween('start_time', [now(), now()->addday()])
            ->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);

        $this->info("Found {$eventCount} {$eventLabel}.");

        $events->each( fn ($event) => $event->ateendees
            ->each( fn ($attendee) => $attendee->user->notify(new EventReminderNotifiction ($event) ))
            );


        $this->info('Reminder sent sucessfully');
    }
}
