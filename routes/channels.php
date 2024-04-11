<?php

use Foundation\Broadcasting\PostChannel;
use Foundation\Broadcasting\ProjectChannel;
use Foundation\Broadcasting\UserChannel;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('users.{user}', UserChannel::class);
Broadcast::channel('projects.{project}', ProjectChannel::class);
Broadcast::channel('posts.{post}', PostChannel::class);
