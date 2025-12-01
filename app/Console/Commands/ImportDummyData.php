<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Carbon\Carbon;

class ImportDummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-dummy-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa usuários, posts e comentários da DummyJSON';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('[+] Iniciando a importação dos dados...');

        $this->info('[+] Obtendo usuários...');

        $usersData = Http::get('https://dummyjson.com/users')->json()['users'];
        
        $bar = $this->output->createProgressBar(count($usersData));
        $bar->start();

        foreach ($usersData as $userData) {
            User::updateOrCreate(
                ['id' => $userData['id']],
                [
                    'firstName' => $userData['firstName'],
                    'lastName'  => $userData['lastName'],
                    'email'     => $userData['email'],
                    'phone'     => $userData['phone'],
                    'image'     => $userData['image'],
                    'birthDate' => Carbon::parse($userData['birthDate'])->format('Y-m-d'),
                    'address'   => $userData['address'],
                    'password'  => $userData['password'],
                ]
            );
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);
        $this->info('[+] Usuários importados com sucesso!');

        $this->info('[+] Obtendo Posts...');
        $postsData = Http::get('https://dummyjson.com/posts?limit=0')->json()['posts'];
        
        $bar = $this->output->createProgressBar(count($postsData));
        $bar->start();

        foreach ($postsData as $postData) {
            if (User::find($postData['userId'])) {
                Post::updateOrCreate(
                    ['id' => $postData['id']],
                    [
                        'user_id'  => $postData['userId'],
                        'title'    => $postData['title'],
                        'body'     => $postData['body'],
                        'tags'     => $postData['tags'],
                        'views'    => $postData['views'] ?? 0,
                        'likes'    => $postData['reactions']['likes'] ?? 0,
                        'dislikes' => $postData['reactions']['dislikes'] ?? 0,
                    ]
                );
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);
        $this->info('[+] Posts importados com sucesso!');

        $this->info('[+] Obtendo comentários...');
        $commentsData = Http::get('https://dummyjson.com/comments?limit=0')->json()['comments'];

        $bar = $this->output->createProgressBar(count($commentsData));
        $bar->start();

        foreach ($commentsData as $commentData) {
            $userId = $commentData['user']['id'];
            $postId = $commentData['postId'];

            if (User::find($userId) && Post::find($postId)) {
                Comment::updateOrCreate(
                    ['id' => $commentData['id']],
                    [
                        'body'    => $commentData['body'],
                        'post_id' => $postId,
                        'user_id' => $userId,
                        'likes'   => $commentData['likes'] ?? 0,
                    ]
                );
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);

        $this->info('[+] TUDO PRONTO! Banco de dados populado com sucesso.');
    
    }
}
