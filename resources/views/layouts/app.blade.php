<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog LoremIpsum</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-white shadow mb-8 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="font-bold text-2xl text-indigo-600 hover:text-indigo-800 transition">
                        Blog LoremIpsum
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition">Início</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Blog LoremIpsum Project. Desenvolvido com Laravel & Tailwind.
        </div>
    </footer>

    <script>
        async function sendReaction(postId, type) {
            const likeCount = document.getElementById(`like-count-${postId}`);
            const dislikeCount = document.getElementById(`dislike-count-${postId}`);
            
            const btn = type === 'like' ? likeCount.parentElement : dislikeCount.parentElement;
            btn.classList.add('scale-110', 'font-bold');
            setTimeout(() => btn.classList.remove('scale-110', 'font-bold'), 200);

            try {
                const response = await fetch(`/post/${postId}/react`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ type: type })
                });

                const data = await response.json();

                if (data.success) {
                    if(likeCount) likeCount.innerText = data.likes;
                    if(dislikeCount) dislikeCount.innerText = data.dislikes;
                }
            } catch (error) {
                console.error('Erro na requisição:', error);
            }
        }
    </script>
</body>
</html>