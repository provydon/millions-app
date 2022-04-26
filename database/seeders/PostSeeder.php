<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();

        // check if storage folder exist
        $folderName = 'public/storage';
		if(!is_dir($folderName))
		{
            Artisan::call('storage:link');
		}

        // check if images folder exist
        $folderName = 'public/storage/images';
		if(!is_dir($folderName))
		{
			mkdir($folderName, 0777, true);
		}
        
        Post::factory(10)->create(); 
    }
}
