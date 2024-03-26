<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="text-white" x-data="{
        users: [],
        messages: {{ json_encode($messages) }},
        init() {
            Echo.private(`private-message-{{ $group }}`)
                .listen('MyPrivateMessage', (e) => {
                    console.log(e)
                    this.messages.push(e.message)
                });
    
        }
    }">
        <h1 class="text-4xl">Private messages for group: {{ $group }}</h1>
        <h2 class="text-2xl">Joined Users</h2>
        <hr>
        <template x-if="!users.length">
            <p style="color: gray">There are no users</p>
        </template>
        <template x-for="user in users">
            <li x-text="user.name"></li>
        </template>

        <h2 class="text-2xl">Messages</h2>
        <hr>
        <template x-if="!messages.length">
            <p style="color: gray">There are no messages</p>
        </template>
        <template x-for="message in messages">
            <li x-text="message.message"></li>
        </template>
    </div>
</x-app-layout>
