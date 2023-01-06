<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookServer\WebhookCall;
use Spatie\WebhookServer\Events\WebhookCallFailedEvent;
use Illuminate\Support\Facades\Http;

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
        // if ($request->is('blog/post/create') && $request->isMethod('post')) {
            
            // $payload = [
            //     "content" => "Post was Published",
            //     "tts" => false,
            //     "embeds" => [[
            //         "title" => "The post with title $request->title was published",
            //         "description" => $request->body,
            //         "timestamp" => now(),
            //         "color" => "178940"
            //     ]]
            // ];
            // WebhookCall::create()
            // ->url('https://discord.com/api/webhooks/'.env('WEBHOOK_ID').'/'.env('WEBHOOK_TOKEN').'')
            // ->throwExceptionOnFailure()
            // ->payload($payload)
            // ->useSecret('sign-using-this-secret')
            // ->dispatch();

            // $response = Http::withBody( 
            //         json_encode($payload), 'json' 
            //     ) 
            //     ->withHeaders([ 
            //         'Accept'=> '*/*', 
            //         'User-Agent'=> 'Thunder Client (https://www.thunderclient.com)', 
            //         'Content-Type'=> 'application/json', 
            //     ]) 
            //     ->post('https://discord.com/api/webhooks/'.env('WEBHOOK_ID').'/'.env('WEBHOOK_TOKEN').''); 

            // if ($response->failed()) {
            //     return throw new \Exception("Error Processing Request", 1);
                
            // }
 
 
        // }
        return $next($request);
    }
}
