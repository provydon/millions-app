<?php

namespace App\Services;

use App\Models\Post;

class General
{
    public static function autoDeleteOldPost(){
        $old_posts = Post::where("created_at","<",now()->addDays(15)->toDateTimeString())->get();
        foreach ($old_posts as $key => $post) {
            print_r("\ndeleting post id; $post->id\n");
            $post->delete();
        }
        print_r("\nDeleted all old posts that has passed 15 days\n");
        return;
    }
}

return new General;
