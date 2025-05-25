<style>
    :root {
        --primary-color: rgb(15, 76, 129);
        --secondary-color: rgb(15, 76, 129);
        --accent-color: rgb(15, 76, 129);
        --light-color: #f8f9fa;
        --dark-color: #212529;
    }

    /* Sidebar Desktop */
    .sidebar {
        width: 250px;
        height: 100vh;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        color: white;
        transition: all 0.3s ease;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow-y: auto;
    }

    .sidebar .logo {
        padding: 20px 15px;
        font-size: 24px;
        font-weight: bold;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        white-space: nowrap;
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        border-radius: 5px;
        margin: 5px 10px;
        transition: all 0.3s;
        text-decoration: none;
        padding: 12px 15px;
        display: block;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .sidebar .nav-link i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .sidebar-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 15px;
        text-align: center;
    }

    .sidebar-footer .btn-chat {
        margin-top: 10px;
        width: 100%;
        padding: 8px;
        font-size: 14px;
        border-radius: 6px;
    }

    /* Chat Container */
    .chat-container {
        display: none;
        background: white;
        color: var(--dark-color);
        border-radius: 8px;
        margin-top: 10px;
        overflow: hidden;
    }

    .chat-container .chat-header {
        background: var(--primary-color);
        color: white;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-container .chat-header h5 {
        margin: 0;
        font-size: 14px;
    }

    .chat-container .chat-header button {
        background: transparent;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }

    .chat-container .chat-body {
        padding: 10px;
    }

    .chat-container .chat-messages {
        height: 200px;
        overflow-y: auto;
        border: 1px solid #eee;
        padding: 8px;
        border-radius: 4px;
        margin-bottom: 10px;
        text-align: left;
        font-size: 12px;
    }

    .chat-container .chat-input-group {
        display: flex;
        gap: 5px;
    }

    .chat-container .chat-input-group input {
        flex: 1;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 12px;
    }

    .chat-container .chat-input-group button {
        padding: 6px 10px;
        border: none;
        background: var(--primary-color);
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
    }

    /* ===== RESPONSIVIDADE MOBILE ===== */
    
    /* Tablets e Mobile */
    @media (max-width: 991.98px) {
        .sidebar {
            transform: translateX(-100%);
            z-index: 1050;
            width: 280px;
        }
        
        .sidebar.active {
            transform: translateX(0);
        }
        
        /* Ajustar chat para mobile */
        .chat-container .chat-messages {
            height: 150px;
        }
        
        .sidebar .logo {
            font-size: 20px;
            padding: 15px;
        }
        
        .sidebar .nav-link {
            padding: 10px 15px;
            font-size: 14px;
        }
    }

    /* Mobile pequeno */
    @media (max-width: 576px) {
        .sidebar {
            width: 260px;
        }
        
        .sidebar .logo {
            font-size: 18px;
            padding: 12px;
        }
        
        .sidebar .nav-link {
            padding: 8px 12px;
            font-size: 13px;
            margin: 3px 8px;
        }
        
        .sidebar .nav-link i {
            margin-right: 8px;
            width: 18px;
        }
        
        .sidebar-footer {
            padding: 10px;
        }
        
        .sidebar-footer .btn-chat {
            font-size: 12px;
            padding: 6px;
        }
        
        .chat-container .chat-messages {
            height: 120px;
        }
        
        .chat-container .chat-header h5 {
            font-size: 12px;
        }
        
        .chat-container .chat-input-group input,
        .chat-container .chat-input-group button {
            font-size: 11px;
            padding: 5px;
        }
    }

    /* Ajustes quando chat está aberto */
    .sidebar.chat-open {
        width: 390px;
    }
    
    @media (max-width: 991.98px) {
        .sidebar.chat-open {
            width: 320px;
        }
    }
    
    @media (max-width: 576px) {
        .sidebar.chat-open {
            width: 300px;
        }
    }

    /* Overlay para mobile */
    .overlay {
        display: none;
        position: fixed;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        top: 0;
        left: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .overlay.active {
        display: block;
        opacity: 1;
    }
</style>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div>
        <div class="logo">
            <i class="bi bi-book"></i> EduSearch
        </div>
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a class="nav-link" href="/home">
                    <i class="bi bi-folder"></i> Minhas Pastas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout" id="logoutButton">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
    </div>
    
    <div class="sidebar-footer">
        <div class="d-flex align-items-center justify-content-center mb-2">
            <div>
                <small>{{ $user->name ?? 'Usuário' }}</small>
            </div>
        </div>
        
        <!-- Botão de Chat -->
        <button id="chatToggle" class="btn btn-light btn-chat">
            <i class="bi bi-chat-dots me-1"></i>Chat IA
        </button>
        
        <!-- Chat Container integrado na Sidebar -->
        <div id="chatContainer" class="chat-container">
            <div class="chat-header">
                <h5><i class="bi bi-robot me-1"></i>Chat IA - Estudos</h5>
                <button id="chatClose">&times;</button>
            </div>
            <div class="chat-body">
                <div class="chat-messages" id="chatMessages">
                    <div><strong>IA:</strong> Olá, como posso ajudar nos seus estudos?</div>
                </div>
                <div class="chat-input-group">
                    <input type="text" id="chatInput" placeholder="Digite sua mensagem..." maxlength="200">
                    <button id="sendBtn">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.getElementById("main-content");
    const chatContainer = document.getElementById("chatContainer");
    
    // Função para atualizar dimensões baseado no tamanho da tela
    function updateSidebarDimensions() {
        const isMobile = window.innerWidth <= 991.98;
        const chatOpen = localStorage.getItem("chatOpen") === "true";
        
        if (isMobile) {
            // Mobile: sidebar não afeta o main-content
            if (mainContent) {
                mainContent.style.marginLeft = "0";
                mainContent.style.width = "100%";
            }
        } else {
            // Desktop: ajustar main-content baseado no estado do chat
            const sidebarWidth = chatOpen ? "390px" : "250px";
            sidebar.style.width = sidebarWidth;
            
            if (mainContent) {
                mainContent.style.marginLeft = sidebarWidth;
                mainContent.style.width = `calc(100% - ${sidebarWidth})`;
            }
        }
        
        // Mostrar/ocultar chat
        if (chatOpen) {
            chatContainer.style.display = "block";
            sidebar.classList.add('chat-open');
        } else {
            chatContainer.style.display = "none";
            sidebar.classList.remove('chat-open');
        }
    }

    // Inicializar dimensões
    updateSidebarDimensions();

    // Toggle do chat
    document.getElementById("chatToggle").addEventListener("click", function() {
        const isVisible = (chatContainer.style.display === "block");
        
        if (isVisible) {
            chatContainer.style.display = "none";
            sidebar.classList.remove('chat-open');
            localStorage.setItem("chatOpen", "false");
        } else {
            chatContainer.style.display = "block";
            sidebar.classList.add('chat-open');
            localStorage.setItem("chatOpen", "true");
        }
        
        updateSidebarDimensions();
    });

    // Fechar chat
    document.getElementById("chatClose").addEventListener("click", function() {
        chatContainer.style.display = "none";
        sidebar.classList.remove('chat-open');
        localStorage.setItem("chatOpen", "false");
        updateSidebarDimensions();
    });

    // Enviar mensagem
    function sendMessage() {
        const input = document.getElementById("chatInput");
        const msg = input.value.trim();
        if (msg !== "") {
            const messages = document.getElementById("chatMessages");
            const userMsg = document.createElement("div");
            userMsg.innerHTML = `<strong>Você:</strong> ${msg}`;
            messages.appendChild(userMsg);
            input.value = "";
            messages.scrollTop = messages.scrollHeight;

            // Enviar para API
            fetch(`http://127.0.0.1:8001/chat/${encodeURIComponent(msg)}`, {
                method: 'GET'
            })
            .then(response => response.text())
            .then(data => {
                const aiMsg = document.createElement("div");
                aiMsg.innerHTML = `<strong>IA:</strong> ${data}`;
                messages.appendChild(aiMsg);
                messages.scrollTop = messages.scrollHeight;
            })
            .catch(error => {
                console.error('Erro:', error);
                const errorMsg = document.createElement("div");
                errorMsg.innerHTML = `<strong>IA:</strong> Desculpe, ocorreu um erro.`;
                messages.appendChild(errorMsg);
                messages.scrollTop = messages.scrollHeight;
            });
        }
    }

    document.getElementById("sendBtn").addEventListener("click", sendMessage);
    
    document.getElementById("chatInput").addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            sendMessage();
        }
    });

    // Atualizar dimensões quando a tela for redimensionada
    window.addEventListener('resize', updateSidebarDimensions);
});
</script>
