<?php

namespace App\Observers;

use MTR\PostPackage\Models\Post;
use Spatie\WebhookServer\WebhookCall;

class PostObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    public function created(Post $post)
    {
        $payload = [
            "content" => "Post was Published",
            "tts" => false,
            "embeds" => [[
                "title" => "The post with title $post->title was published",
                "description" => $post->body,
                "timestamp" => now(),
                "color" => "178940"
            ]]
        ];
        WebhookCall::create()
            ->url('https://discord.com/api/webhooks/'.env('WEBHOOK_ID').'/'.env('WEBHOOK_TOKEN').'')
            ->throwExceptionOnFailure()
            ->payload($payload)
            ->useSecret('sign-using-this-secret')
            ->dispatch();
    }
}
