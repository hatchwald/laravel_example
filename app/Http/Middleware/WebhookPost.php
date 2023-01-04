<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookServer\WebhookCall;

class WebhookPost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::debug("llewat sini");
        if ($request->is('blog/post/create') && $request->isMethod('post')) {
            Log::debug("some are");
            Log::debug(env('WEBHOOK_ID'));
            $payload = [
                "content" => "Post was Published",
                "tts" => false,
                "embeds" => [[
                    "title" => "The post with title $request->title was published",
                    "description" => $request->body,
                ]]
            ];
            WebhookCall::create()
            ->url('https://discord.com/api/webhooks/'.env('WEBHOOK_ID').'/'.env('WEBHOOK_TOKEN').'')
            ->payload($payload)
            ->useSecret('sign-using-this-secret')
            ->dispatch();
        }
        return $next($request);
    }
}
