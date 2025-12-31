@extends('tamotech.layout.index')
@section('title')
    {{__('main.terminal')}}
@endsection
@section("style")
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <style>
        #terminal {
            width: 100%;
            height: 400px;            /* max-width: 800px; */
            background-color: #2d2d2d;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }
        #output {
            height: 400px;
            width: 100%;
            overflow-y: scroll;
            background-color: #1e1e1e;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            margin-bottom: 10px;
            color: #ffffff; /* أضف السطر ده */
        }
        .command-select, #command-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: #1e1e1e;
            color: #d4d4d4;
            display: block;
            margin-bottom: 10px;
        }
        #command-input {
            display: none;
        }
        button {
            padding: 10px 20px;
            border: 1px solid #555;
            border-radius: 4px;
            background-color: #007acc;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #005f99;
        }
        pre {
            margin: 0;
        }
    </style>
@endsection
@section('content')
    <div id="terminal" style="width:100% ; height: 70%">
        <div id="output"></div>
        <select class="command-select" id="command-select" onchange="toggleCommandInput()">
            <option value="">{{ __("main.Select a command") }}</option>
            @foreach($commands as $command)
                <option value="{{ $command->command }}">{{ $command->command }}</option>
            @endforeach
            <option value="clear">{{ __("main.Clear") }}</option>
            <option value="custom">{{ __("main.Other (type your command)") }}</option>
        </select>
        <select class="command-select" id="type">
            <option value="project" selected>project</option>
            <option value="vendor">vendor</option>
        </select>
        <input type="text" id="command-input" placeholder="Enter command">
        <button id="executeBtn" onclick="sendCommand()">{{ __('main.Execute') }}</button>
    </div>


@endsection
@section('js')
<script>
    function toggleCommandInput() {
        var type = document.getElementById('type');
        var select = document.getElementById('command-select');
        var input = document.getElementById('command-input');
        if (select.value === 'custom') {
            input.style.display = 'block';
        } else {
            input.style.display = 'none';
        }
    }

    function sendCommand() {
        var btn = document.getElementById('executeBtn');
        btn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>`;
        btn.disabled = true;
        var type = document.getElementById('type');
        var select = document.getElementById('command-select');
        var input = document.getElementById('command-input');
        var command = select.value === 'custom' ? input.value : select.value;

        if (!command) {
            alert('Please select or enter a command');
            return;
        }

        if (command === 'clear') {
            clearOutput(); // Call the function to clear output
            return;
        }

        fetch('{{ route('terminal.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ command: command, type: type.value })
        })
            .then(response => response.json())
            .then(data => {
                var outputDiv = document.getElementById('output');
                if (data.output) {
                    outputDiv.innerHTML += '<pre>' + data.output + '</pre>';
                } else {
                    outputDiv.innerHTML += '<pre>Command not allowed</pre>';
                }
                input.value = '';
                if (select.value !== 'custom') {
                    select.value = '';
                }
                input.style.display = 'none';
                outputDiv.scrollTop = outputDiv.scrollHeight; // Scroll to bottom of output
                btn.innerHTML = `{{ __('main.Execute') }}`;
                btn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                var outputDiv = document.getElementById('output');
                btn.innerHTML = `{{ __('main.Execute') }}`;
                btn.disabled = false;
                outputDiv.innerHTML += '<pre>Error executing command</pre>';
            });
    }

    function clearOutput() {
        document.getElementById('output').innerHTML = ''; // Clear the output div
        var btn = document.getElementById('executeBtn');
        btn.innerHTML = `{{ __('main.Execute') }}`;
        btn.disabled = false;
    }
</script>
</script>
@endsection
