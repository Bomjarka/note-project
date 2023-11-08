<?php

namespace Tests\Unit\Services;

use App\Models\Note;
use App\Models\User;
use App\Services\NoteService;
use Database\Factories\NoteFactory;
use Tests\TestCase;

class NoteServiceTest extends TestCase
{
    private User $user;
    private NoteService $noteService;

    public function setUp(): void
    {
        parent::setUp();

        $this->noteService = new NoteService();
        $this->user = User::factory(1)->create()->first();
    }

    /**
     * A basic test example.
     */
    public function testCanCreateNewNote(): void
    {
        $data = [
            'topic' => 'Test topic',
            'content' => 'test content',
            'user_id' => $this->user->id,
        ];

        $noteExists = Note::whereTopic($data['topic'])
            ->whereContent($data['content'])
            ->whereUserId($data['user_id'])
            ->exists();
        $this->assertFalse($noteExists);

        $note = $this->noteService->createOrUpdate($data);
        $this->assertModelExists($note);
    }

    public function testCanUpdateExistsNote()
    {
        $data = [
            'topic' => 'Test topic',
            'content' => 'test content',
            'user_id' => $this->user->id,
        ];

        $note = Note::factory(1)->create([
            'user_id' => $data['user_id'],
            'topic' => $data['topic'],
            'content' => $data['content'],
        ])->first();

        $this->assertModelExists($note);

        $dataToUpdate = [
            'topic' => 'New Test topic',
            'content' => 'New test content',
            'user_id' => $this->user->id,
        ];
        $updatedNote = $this->noteService->createOrUpdate($dataToUpdate, $note->id);

        $this->assertEquals($note->id, $updatedNote->id);
        $this->assertEquals($dataToUpdate['topic'], $updatedNote->topic);
        $this->assertEquals($dataToUpdate['content'], $updatedNote->content);
        $this->assertEquals($dataToUpdate['user_id'], $updatedNote->user_id);
    }
}
