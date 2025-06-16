@component('mail::message')

You have a task "**{{ $task->title }}**" due on **{{ $task->date->format('Y-m-d H:i') }}**.

Please make sure to complete it on time.

Thanks,<br>
{{ config('app.name') }}
@endcomponent