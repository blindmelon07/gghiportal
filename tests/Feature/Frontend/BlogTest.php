<?php

use App\Models\Post;
use Livewire\Livewire;

it('shows blog index', function () {
    $this->get(route('blog.index'))->assertOk();
});

it('shows a published post', function () {
    $post = Post::factory()->published()->create();
    $this->get(route('blog.show', $post->slug))->assertOk()->assertSee($post->title);
});

it('returns 404 for unpublished post', function () {
    $post = Post::factory()->draft()->create();
    $this->get(route('blog.show', $post->slug))->assertNotFound();
});

it('can search posts', function () {
    $post = Post::factory()->published()->create(['title' => 'Heart Surgery Tips']);
    Livewire::test(\App\Livewire\Frontend\PostIndex::class)
        ->set('search', 'Heart')
        ->assertSee('Heart Surgery Tips');
});
