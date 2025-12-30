<div id="ai-agent-widget" class="fixed bottom-6 right-6 w-80 max-w-full z-50">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-semibold">Agen TERANG (AI)</div>
        <div class="p-3">
            <div id="ai-messages" class="h-40 overflow-auto text-sm space-y-2 mb-3 text-gray-700"></div>
            <div class="flex items-center gap-2">
                <input id="ai-input" type="text" placeholder="Tanyakan sesuatu..." class="flex-1 px-3 py-2 border rounded-lg text-sm" />
                <button id="ai-send" class="px-3 py-2 bg-blue-600 text-white rounded-lg text-sm">Kirim</button>
            </div>
        </div>
    </div>
</div>

<script>
    (function(){
        const sendBtn = document.getElementById('ai-send');
        const input = document.getElementById('ai-input');
        const messages = document.getElementById('ai-messages');

        function appendMessage(text, from='bot'){
            const el = document.createElement('div');
            el.className = from === 'bot' ? 'bg-gray-100 p-2 rounded-md' : 'bg-blue-50 p-2 rounded-md text-right';
            el.textContent = text;
            messages.appendChild(el);
            messages.scrollTop = messages.scrollHeight;
        }

        async function send(){
            const msg = input.value.trim();
            if(!msg) return;
            appendMessage(msg, 'user');
            input.value = '';
            appendMessage('Mencari jawaban...', 'bot');

            try{
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch('/api/ai/agent/query', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token || ''
                    },
                    body: JSON.stringify({ message: msg })
                });
                const json = await res.json();
                // Remove the 'Mencari jawaban...' placeholder
                if(messages.lastChild && messages.lastChild.textContent === 'Mencari jawaban...'){
                    messages.removeChild(messages.lastChild);
                }
                if(json.error){
                    appendMessage('Error: ' + (json.error || 'unknown'), 'bot');
                } else {
                    // try to display assistant reply; adjust according to Groq response shape
                    let reply = '';
                    if(json.choices && json.choices[0] && json.choices[0].message){
                        reply = json.choices[0].message.content || JSON.stringify(json);
                    } else if(json.output){
                        reply = JSON.stringify(json.output);
                    } else {
                        reply = JSON.stringify(json);
                    }
                    appendMessage(reply, 'bot');
                }
            } catch(e){
                appendMessage('Exception: ' + e.message, 'bot');
            }
        }

        sendBtn.addEventListener('click', send);
        input.addEventListener('keydown', function(e){ if(e.key === 'Enter') send(); });
    })();
</script>
