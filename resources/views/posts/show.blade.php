@extends('layouts.app')

@section('content')
    <a href="{{ route('home') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6 transition-colors font-medium">
        &larr; Voltar para a Home
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2">
            <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="p-8">
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('home', ['tag' => $tag]) }}" class="bg-indigo-50 text-indigo-700 text-sm font-bold px-3 py-1 rounded-full uppercase tracking-wide hover:bg-indigo-100 hover:text-indigo-800 transition">
                                #{{ $tag }}
                            </a>
                        @endforeach
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6 leading-tight">
                        {{ $post->title }}
                    </h1>

                    <div class="prose prose-indigo max-w-none text-gray-600 leading-relaxed text-lg text-justify">
                        {{ $post->body }}
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-6 text-sm text-gray-500 font-semibold select-none">
                        <button onclick="sendReaction({{ $post->id }}, 'like')" class="flex items-center gap-2 hover:text-green-600 transition transform active:scale-95 px-3 py-1 rounded-md hover:bg-green-50">
                            <span class="text-xl">👍</span> 
                            <span id="like-count-{{ $post->id }}">{{ $post->likes }}</span>
                        </button>
                        
                        <button onclick="sendReaction({{ $post->id }}, 'dislike')" class="flex items-center gap-2 hover:text-red-600 transition transform active:scale-95 px-3 py-1 rounded-md hover:bg-red-50">
                            <span class="text-xl">👎</span> 
                            <span id="dislike-count-{{ $post->id }}">{{ $post->dislikes }}</span>
                        </button>
                    </div>
                    <div class="text-sm text-gray-400 font-medium">
                        Visualizado {{ $post->views }} vezes
                    </div>
                </div>
            </article>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    Comentários 
                    <span class="bg-indigo-100 text-indigo-800 text-sm py-0.5 px-2.5 rounded-full">{{ $post->comments->count() }}</span>
                </h3>

                <div class="space-y-6">
                    @forelse($post->comments as $comment)
                        <div class="flex gap-4 p-4 rounded-lg hover:bg-gray-50 transition border-b border-gray-50 last:border-0">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-sm">
                                    {{ substr($comment->user->username ?? 'U', 0, 1) }}
                                </div>
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-bold text-gray-900 text-sm">
                                        {{ $comment->user->username ?? 'Anônimo' }}
                                    </h4>
                                    <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 text-sm">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <p class="italic">Nenhum comentário ainda. Seja o primeiro!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <aside>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Sobre o Autor</h3>
                
                <div class="flex flex-col items-center text-center mb-6">
                    <img src="{{ $post->user->image }}" alt="" class="h-24 w-24 rounded-full border-4 border-indigo-50 shadow-md mb-4 object-cover">
                    <h4 class="font-bold text-lg text-gray-900">{{ $post->user->firstName }} {{ $post->user->lastName }}</h4>
                    <p class="text-sm text-gray-500">{{ $post->user->email }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $post->user->company['title'] ?? 'Autor' }}</p>
                </div>

                <div class="border-t border-gray-100 pt-4 mb-4 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Idade</span>
                        <span class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($post->user->birthDate)->age }} anos</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Telefone</span>
                        <span class="font-semibold text-gray-700">{{ $post->user->phone }}</span>
                    </div>
                </div>

                <a href="{{ route('users.posts', $post->user->id) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition-colors shadow-sm hover:shadow-md">
                    Ver Posts do Autor
                </a>
            </div>
        </aside>

    </div>
@endsection