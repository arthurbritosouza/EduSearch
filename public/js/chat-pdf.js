// Configura o marked para renderizar quebras de linha simples como <br>
marked.setOptions({ breaks: true });

// Função para processar texto com escape de caracteres e remover aspas
function processText(text) {
    text = text.trim();
    if ((text.startsWith('"') && text.endsWith('"')) || (text.startsWith("'") && text.endsWith("'"))) {
        text = text.slice(1, -1);
    }
    return text.replace(/\\n/g, '\n').replace(/\\t/g, '\t').replace(/\\r/g, '\r');
}

// Função para escapar HTML (para mensagens do usuário)
function escapeHtml(text) {
    return text.replace(/&/g, "&amp;")
               .replace(/</g, "&lt;")
               .replace(/>/g, "&gt;")
               .replace(/"/g, "&quot;")
               .replace(/'/g, "&#039;");
}

// Função para obter hora atual formatada
function getCurrentTime() {
    return new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
}

// Função para rolar o chat para o fim
function scrollToBottom() {
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

// Função para adicionar mensagem ao chat (com Markdown para IA, escape para usuário)
function addMessage(text, isUser = false) {
    const chatMessages = document.getElementById('chatMessages');
    if (!chatMessages) return;

    const messageDiv = document.createElement('div');
    messageDiv.className = 'message ' + (isUser ? 'user-message' : 'ai-message');

    const avatarIcon = isUser ? 'bi-person' : 'bi-robot';
    const timeString = getCurrentTime();

    let messageContent = '';
    if (isUser) {
        messageContent = `<div class="message-text">${escapeHtml(text)}</div>`;
    } else {
        const processedText = processText(text);
        const htmlContent = marked.parse(processedText);
        messageContent = `<div class="message-text">${htmlContent}</div>`;
    }

    messageDiv.innerHTML = `
        <div class="message-avatar"><i class="bi ${avatarIcon}"></i></div>
        <div class="message-content">
            ${messageContent}
            <div class="message-time">${timeString}</div>
        </div>
    `;

    chatMessages.appendChild(messageDiv);
    scrollToBottom();
}

// Função para enviar mensagem (para API)
async function sendMessage() {
    const input = document.getElementById('chatInput');
    if (!input) return;

    const msg = input.value.trim();
    if (!msg) return;

    addMessage(msg, true);
    input.value = '';

    const user_id = document.getElementById('user_id')?.value;
    const title = document.getElementById('title')?.value;

    if (!user_id || !title) {
        addMessage('Erro: user_id ou title não definidos.');
        return;
    }

    const apiUrl = `http://127.0.0.1:8001/chat_file/${encodeURIComponent(msg)}/${encodeURIComponent(user_id)}/${encodeURIComponent(title)}`;

    try {
        const response = await fetch(apiUrl);
        if (!response.ok) throw new Error('Erro na API');
        const data = await response.text();
        addMessage(data);
    } catch (error) {
        console.error('Erro ao enviar mensagem:', error);
        addMessage('Desculpe, ocorreu um erro ao enviar sua mensagem.');
    }
}

// Função para limpar o chat
function clearChat() {
    const chatMessages = document.getElementById('chatMessages');
    if (!chatMessages) return;

    chatMessages.innerHTML = `
        <div class="message ai-message">
            <div class="message-avatar">
                <i class="bi bi-robot"></i>
            </div>
            <div class="message-content">
                <div class="message-text">
                    Olá! Como posso ajudá-lo hoje?
                </div>
                <div class="message-time">${getCurrentTime()}</div>
            </div>
        </div>
    `;
    scrollToBottom();
}

// Inicialização após DOM carregado
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const overlay = document.getElementById('overlay');

    if (sidebarCollapse && sidebar && mainContent && overlay) {
        sidebarCollapse.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    // Elementos do chat
    const chatInput = document.getElementById('chatInput');
    const sendButton = document.getElementById('sendMessage');
    const clearChatBtn = document.getElementById('clearChat');

    if (chatInput && sendButton) {
        // Event listeners únicos
        sendButton.addEventListener('click', sendMessage);
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });
    }

    if (clearChatBtn) {
        clearChatBtn.addEventListener('click', clearChat);
    }

    // Foco no input ao mostrar aba do chat
    const chatTab = document.getElementById('chat-tab');
    if (chatTab) {
        chatTab.addEventListener('shown.bs.tab', () => {
            setTimeout(() => {
                if (chatInput) chatInput.focus();
            }, 100);
        });
    }

    // Inicializa chat com mensagem padrão
    clearChat();
});

// Função global para perguntas sugeridas
window.askQuestion = (question) => {
    const chatInput = document.getElementById('chatInput');
    if (chatInput) {
        chatInput.value = question;
        sendMessage();
    }
};
