<div>
    <div class="flex gap-2 mb-5">
        @foreach(['all' => 'All', 'unread' => 'Unread', 'read' => 'Read'] as $val => $label)
        <button wire:click="$set('filter', '{{ $val }}')"
            class="{{ $filter === $val ? 'bg-brand-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }} px-4 py-1.5 rounded-full text-sm font-medium border border-gray-200 transition-colors">
            {{ $label }}
        </button>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @forelse($messages as $msg)
        <div class="border-b border-gray-50 last:border-0">
            <div
                wire:click="expand({{ $msg->id }})"
                class="flex items-center gap-4 px-5 py-4 cursor-pointer hover:bg-gray-50 transition-colors {{ ! $msg->is_read ? 'bg-blue-50/50' : '' }}">
                <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($msg->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-800 text-sm">{{ $msg->name }}</span>
                        @if(!$msg->is_read)
                        <span class="w-2 h-2 bg-brand-500 rounded-full"></span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 truncate">{{ $msg->subject ?: $msg->email }}</p>
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0">{{ $msg->created_at->diffForHumans() }}</span>
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform {{ $expandedId === $msg->id ? 'rotate-180' : '' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>

            @if($expandedId === $msg->id)
            <div class="px-5 py-4 bg-gray-50 border-t border-gray-100">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-xs mb-3">
                    <div><span class="text-gray-400">Email:</span> <a href="mailto:{{ $msg->email }}" class="text-brand-500">{{ $msg->email }}</a></div>
                    @if($msg->phone)
                    <div><span class="text-gray-400">Phone:</span> {{ $msg->phone }}</div>
                    @endif
                    @if($msg->subject)
                    <div><span class="text-gray-400">Subject:</span> {{ $msg->subject }}</div>
                    @endif
                    <div><span class="text-gray-400">Date:</span> {{ $msg->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-sm text-gray-700 border border-gray-100 whitespace-pre-line">{{ $msg->message }}</div>
                <div class="flex gap-3 mt-3 justify-end">
                    <button wire:click="delete({{ $msg->id }})"
                        wire:confirm="Delete this message?"
                        class="text-xs text-red-400 hover:text-red-600 font-medium">Delete</button>
                </div>
            </div>
            @endif
        </div>
        @empty
        <p class="text-center text-gray-400 py-12">No messages found.</p>
        @endforelse
    </div>
</div>
