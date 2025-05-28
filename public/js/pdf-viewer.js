// Inicialização do Sidebar
function initializeSidebar() {
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const overlay = document.getElementById('overlay');

    if (sidebarCollapse && sidebar && mainContent && overlay) {
        sidebarCollapse.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
            overlay.classList.remove('active');
        });
    }
}

// Inicialização do Chat
function initializeChat() {
    const chatInput = document.getElementById('chatInput');
    const sendButton = document.getElementById('sendMessage');
    const chatMessages = document.getElementById('chatMessages');
    const clearChatBtn = document.getElementById('clearChat');

    if (!chatInput || !sendButton || !chatMessages) {
        console.error('Elementos do chat não encontrados!');
        return;
    }

    // Função para enviar mensagem
    const sendMessage = () => {
        const message = chatInput.value.trim();
        if (!message) return;

        // Adicionar mensagem do usuário
        addUserMessage(message);
        chatInput.value = '';

        // Simular resposta da IA
        setTimeout(() => {
            addAIMessage(message);
        }, 1000);
    };

    // Event Listeners
    sendButton.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    if (clearChatBtn) {
        clearChatBtn.addEventListener('click', () => {
            if (confirm('Limpar todo o chat?')) {
                chatMessages.innerHTML = `
                    <div class="message ai-message">
                        <div class="message-avatar">
                            <i class="bi bi-robot"></i>
                        </div>
                        <div class="message-content">
                            <div class="message-text">
                                Olá! Eu sou seu assistente de IA para este documento. Como posso ajudá-lo hoje?
                            </div>
                            <div class="message-time">${getCurrentTime()}</div>
                        </div>
                    </div>
                `;
            }
        });
    }

    // Funções auxiliares
    function addUserMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message user-message';
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="message-content">
                <div class="message-text">${escapeHtml(message)}</div>
                <div class="message-time">${getCurrentTime()}</div>
            </div>
        `;
        chatMessages.appendChild(messageDiv);
        scrollToBottom();
    }

    function addAIMessage(userMessage) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message ai-message';
        
        // Resposta simulada
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <i class="bi bi-robot"></i>
            </div>
            <div class="message-content">
                <div class="message-text">${generateAIResponse(userMessage)}</div>
                <div class="message-time">${getCurrentTime()}</div>
            </div>
        `;
        chatMessages.appendChild(messageDiv);
        scrollToBottom();
    }

    function generateAIResponse(message) {
        // Lógica de resposta simulada
        return `Resposta para: <strong>${message}</strong>`;
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function getCurrentTime() {
        return new Date().toLocaleTimeString('pt-BR', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Inicialização Geral
document.addEventListener('DOMContentLoaded', () => {
    console.log('Inicializando PDF Viewer...');
    initializeSidebar();
    initializeChat();
    
    // Inicializar eventos de aba
    const chatTab = document.getElementById('chat-tab');
    if (chatTab) {
        chatTab.addEventListener('shown.bs.tab', () => {
            console.log('Aba do chat ativada');
            const chatInput = document.getElementById('chatInput');
            if (chatInput) chatInput.focus();
        });
    }
});