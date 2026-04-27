<?php

use App\Models\Admin;
use App\Models\Post;
use Livewire\Livewire;

beforeEach(fn () => $this->actingAs(Admin::factory()->create(), 'admin'));

it('lists posts', function () {
    $this->get(route('admin.posts.index'))->assertOk();
});

it('creates a post', function () {
    Livewire::test(\App\Livewire\Admin\Posts\PostForm::class)
        ->set('title', 'New Health Article')
        ->set('author_name', 'Dr. Santos')
        ->set('body', 'Article body content here.')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.posts.index'));
    expect(Post::where('title', 'New Health Article')->exists())->toBeTrue();
});

it('validates post creation', function () {
    Livewire::test(\App\Livewire\Admin\Posts\PostForm::class)
        ->call('save')
        ->assertHasErrors(['title', 'body', 'author_name']);
});

it('edits a post', function () {
    $post = Post::factory()->create();
    Livewire::test(\App\Livewire\Admin\Posts\PostForm::class, ['post' => $post])
        ->set('title', 'Updated Title')
        ->call('save')
        ->assertHasNoErrors();
    expect($post->fresh()->title)->toBe('Updated Title');
});

it('deletes a post', function () {
    $post = Post::factory()->create();
    Livewire::test(\App\Livewire\Admin\Posts\PostIndex::class)
        ->call('delete', $post->id)
        ->assertHasNoErrors();
    expect(Post::find($post->id))->toBeNull();
});

it('toggles post publish status', function () {
    $post = Post::factory()->draft()->create();
    Livewire::test(\App\Livewire\Admin\Posts\PostIndex::class)
        ->call('togglePublish', $post->id);
    expect($post->fresh()->is_published)->toBeTrue();
});
