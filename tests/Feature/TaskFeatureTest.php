<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\TaskReminderMail;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Passport;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (app()->runningUnitTests()) {
            $clientRepo = app(ClientRepository::class);
            $clientRepo->createPersonalAccessClient(
                null,
                'Test Personal Access Client',
                'http://localhost'
            );
        }
    }
    public function test_user_can_create_task_with_valid_data()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->postJson('/api/v1/tasks', [
            'title' => 'Test Task',
            'description' => 'Test description',
            'date' => now()->addDays(2)->toDateTimeString(),
            'priority' => 'LOW',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['data' => ['id', 'title', 'description', 'date', 'status', 'priority', 'created_at']]);

        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_task_creation_fails_with_past_due_date()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        $response = $this->postJson('/api/v1/tasks', [
            'title' => 'Test Task',
            'date' => now()->subDay()->toDateTimeString(),
        ]);

        $response->assertStatus(422);
    }

    public function test_user_can_update_task_status_in_valid_flow()
    {
        $task = Task::factory()->create(['status' => 1]);
        Passport::actingAs($task->user);

        $response = $this->patchJson("/api/v1/tasks/{$task->id}", [
            'status' => 'COMPLETED'
        ]);

        $response->assertStatus(200);
    }

    public function test_user_cannot_directly_complete_task_from_pending()
    {
        $task = Task::factory()->create(['status' => 0]);
        Passport::actingAs($task->user);
        $response = $this->patchJson("/api/v1/tasks/{$task->id}", [
            'status' => 'COMPLETED'
        ]);

        $response->assertStatus(400);
    }

    public function test_soft_delete_task()
    {
        $task = Task::factory()->create();
        Passport::actingAs($task->user);
        $response = $this->deleteJson("/api/v1/tasks/{$task->id}");
        $response->assertStatus(204);

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    public function test_list_tasks_with_filters_and_sorting()
    {
        $user = User::factory()->create();
        Task::factory()->count(5)->create(['status' => 0, 'user_id' => $user->id]);
        Passport::actingAs($user);
        $response = $this->getJson('/api/v1/tasks?status=PENDING&sortedBy=date&orderedBy=asc');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
    }

    public function test_full_text_search_tasks()
    {
        $user = User::factory()->create();
        Task::factory()->create(['title' => 'Important Deadline', 'user_id' => $user->id]);

        Passport::actingAs($user);
        $response = $this->getJson('/api/v1/tasks?search=Deadline');

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Important Deadline']);
    }

    public function test_priority_sorting_works()
    {
        $user = User::factory()->create();
        Task::factory()->create(['priority' => 2, 'user_id' => $user->id]);
        Task::factory()->create(['priority' => 1, 'user_id' => $user->id]);
        Passport::actingAs($user);
        $response = $this->getJson('/api/v1/tasks?sortedBy=priority&orderedBy=desc');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertEquals('HIGH', $data[0]['priority']);
    }

    public function test_task_reminder_email_sent_24_hours_before()
    {
        Mail::fake();

        $user = User::factory()->create();
        $task = Task::factory()->create([
            'date' => now()->addDay()->startOfHour(),
            'user_id' => $user->id
        ]);

        $this->artisan('tasks:send-reminders')
            ->expectsOutput('Reminder emails queued for 1 tasks.')
            ->assertExitCode(0);

        Mail::assertQueued(TaskReminderMail::class, function ($mail) use ($task) {
            return $mail->task->id === $task->id;
        });
    }
}