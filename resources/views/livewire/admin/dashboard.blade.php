<div>
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        @foreach([
            ['label' => 'Total Posts',    'value' => $totalPosts,     'color' => 'bg-blue-50 text-blue-700 border-blue-100'],
            ['label' => 'Published',      'value' => $publishedPosts, 'color' => 'bg-green-50 text-green-700 border-green-100'],
            ['label' => 'Services',       'value' => $totalServices,  'color' => 'bg-purple-50 text-purple-700 border-purple-100'],
            ['label' => 'Unread Msgs',    'value' => $unreadMessages, 'color' => 'bg-red-50 text-red-700 border-red-100'],
            ['label' => 'Gallery Images', 'value' => $galleryImages,  'color' => 'bg-yellow-50 text-yellow-700 border-yellow-100'],
            ['label' => 'Hero Slides',    'value' => $heroSlides,     'color' => 'bg-indigo-50 text-indigo-700 border-indigo-100'],
        ] as $stat)
        <div class="bg-white rounded-xl border {{ $stat['color'] }} p-4 text-center shadow-sm">
            <div class="text-2xl font-bold">{{ $stat['value'] }}</div>
            <div class="text-xs font-medium mt-1">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent Posts --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-800">Recent Posts</h2>
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-brand-500 hover:underline">View all</a>
            </div>
            <table class="w-full text-sm">
                <thead class="text-xs text-gray-500 border-b">
                    <tr>
                        <th class="pb-2 text-left font-medium">Title</th>
                        <th class="pb-2 text-left font-medium">Status</th>
                        <th class="pb-2 text-left font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentPosts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 pr-2 truncate max-w-[180px]">{{ $post->title }}</td>
                        <td class="py-2 pr-2">
                            <span class="{{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} text-xs px-2 py-0.5 rounded-full">
                                {{ $post->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="py-2">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-brand-500 hover:underline text-xs">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Unread Messages --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-800">Unread Messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-xs text-brand-500 hover:underline">View all</a>
            </div>
            @forelse($recentMessages as $msg)
            <div class="py-2 border-b border-gray-50 last:border-0">
                <div class="flex justify-between text-sm">
                    <span class="font-medium text-gray-700">{{ $msg->name }}</span>
                    <span class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-xs text-gray-500 truncate">{{ $msg->subject ?: $msg->message }}</p>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">No unread messages</p>
            @endforelse
        </div>
    </div>
</div>
