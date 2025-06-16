<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Mail\TaskReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send task email reminders 24 hours before due date';

    public function handle()
    {
        $now = now();
        $from = $now->copy()->addDay()->startOfHour();
        $to   = $from->copy()->addHour();

        $tasks = Task::whereBetween('date', [$from, $to])
            ->with('user')
            ->get();

        $count = 0;

        foreach ($tasks as $task) {
            if ($task->user && $task->user->email) {
                Mail::to($task->user->email)
                    ->queue(new TaskReminderMail($task));
                $count++;
            }
        }

        $this->info("Reminder emails queued for {$count} tasks.");
    }
}
