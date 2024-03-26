<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/js/app.js'])
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <h1>Public messages</h1>
    <div x-data="{
        messages: {{ json_encode($messages->map(fn($m) => $m->message)) }},
        init() {
            Echo.channel('public-message')
                .listen('MyPublicMessage', (e) => {
                    this.messages.push(e.message)
                })
    
        }
    }">
        <template x-for="message in messages">
            <li x-text="message"></li>
        </template>
    </div>
</body>

</html>
