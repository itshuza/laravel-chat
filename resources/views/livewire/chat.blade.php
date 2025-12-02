<div class="flex flex-col space-y-6">

    <!-- Heading -->
    <div class="relative mb-6 w-full">
        <h1 class="text-2xl font-bold">{{ __('Chat') }}</h1>
        <p class="text-gray-500 text-lg mb-6">{{ __('Manage your profile and account settings') }}</p>
        <hr class="border-gray-200" />
    </div>

    <!-- Chat Container -->
    <div class="flex h-[550px] text-sm border rounded-xl shadow overflow-hidden bg-white">

        <!-- Left: User List -->
        <div class="w-1/4 border-r bg-gray-50">
            <div class="p-4 font-bold text-gray-700 border-b">Users</div>
            <div class="divide-y">
                @foreach ($users as $user)
                    
                
                <div wire:click="selectUser({{ $user->id }})"p-3 cursor-pointer hover:bg-blue-100 transition
                    {{ $selecteduser->id===$user->id? 'bg-light fw-semibold ':'' }}">
                    <div class="text-gray-800">{{ $user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                </div>
                @endforeach
                <!-- Add more users here -->
            </div>
        </div>

        <!-- Right: Chat Section -->
        <div class="w-3/4 flex flex-col">

            <!-- Header -->
            <div class="p-4 border-b bg-gray-50">
                <div class="text-lg font-semibold text-gray-800">{{ $selecteduser->name }}</div>
                <div class="text-xs text-gray-500">{{ $selecteduser->name }}</div>
            </div>

            <!-- Messages -->
            <div class="flex-1 p-4 overflow-y-auto space-y-2 bg-gray-50">
                  @foreach ($messages as $message)
                <div class="flex {{ $message['sender_id'] === auth()->id() ? 'justify-end':'justify-start' }}">
    <div class="max-w-xs px-4 py-2 rounded-2xl shadow
        {{ $message['sender_id'] === auth()->id() ? 'bg-blue-600 text-white':'bg-gray-200 text-black' }}">
        {{ $message['message'] }}
    </div>
</div>
                 @endforeach
                <!-- Add more messages here -->
            </div>
          

            <!-- Input -->
            <form wire:submit.prevent="submit" p-4 border-t bg-white flex items-center gap-2">
                <input 
                    wire:model.defer="newMessage"
                    type="text"
                    placeholder="Type your message..."
                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300"
                />
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-full transition">
                    Send
                </button>
            </form>

        </div>
    </div>
</div>
