<style>
    :root {
        --primary-color: rgb(15, 76, 129);
        --secondary-color: rgb(15, 76, 129);
        --accent-color: rgb(15, 76, 129);
        --light-color: #f8f9fa;
        --dark-color: #212529;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        height: 100vh;
        background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        color: white;
        transition: all 0.3s;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .sidebar .logo {
        padding: 20px 15px;
        font-size: 24px;
        font-weight: bold;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        border-radius: 5px;
        margin: 5px 10px;
        transition: all 0.3s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .sidebar .nav-link i {
        margin-right: 10px;
    }

    .sidebar-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 9px;
        text-align: center;
    }

    .sidebar-footer .btn-chat {
        margin-top: 10px;
        width: 100%;
        padding: 8px;
        font-size: 16px;
    }

    /* Estilos para o Chat integrado na sidebar */
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
        font-size: 16px;
    }

    .chat-container .chat-header button {
        background: transparent;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }

    .chat-container .chat-body {
        padding: 10px;
    }

    .chat-container .chat-messages {
        /* Ajuste a altura do chat aqui: altere o valor da propriedade 'height' para aumentar ou diminuir */
        height: 250px;
        overflow-y: auto;
        border: 1px solid #eee;
        padding: 5px;
        border-radius: 4px;
        margin-bottom: 10px;
        text-align: left;
        /* As mensagens ficarão alinhadas à esquerda */
    }

    .chat-container .chat-input-group {
        display: flex;
    }

    .chat-container .chat-input-group input {
        flex: 1;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .chat-container .chat-input-group button {
        margin-left: 5px;
        padding: 8px 12px;
        border: none;
        background: var(--primary-color);
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

</style>
<link rel="icon" href="{{ asset('logo_edusearch.png') }}" type="image/png">
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
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="#">--}}
{{--                    <i class="bi bi-star"></i> Favoritos--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="#">--}}
{{--                    <i class="bi bi-share"></i> Compartilhados--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="#">--}}
{{--                    <i class="bi bi-clock-history"></i> Histórico--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="#">--}}
{{--                    <i class="bi bi-gear"></i> Configurações--}}
{{--                </a>--}}
{{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link" href="/logout" id="logoutButton">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar-footer">
        <div class="d-flex align-items-center justify-content-center">
            <div>
                <small>{{ $user->name }}</small>
            </div>
        </div>
        
        <!-- Botão de Chat -->
        <button id="chatToggle" class="btn btn-light btn-chat mt-2">Chat IA</button>
        <!-- Chat Container integrado na Sidebar -->
        <div id="chatContainer" class="chat-container">
            <div class="chat-header">
                <h5>Chat IA - Estudos</h5>
                <button id="chatClose">&times;</button>
            </div>
            <div class="chat-body">
                <div class="chat-messages" id="chatMessages">
                    <div><strong>IA:</strong> Olá, como posso ajudar nos seus estudos?</div>
                </div>
                <div class="chat-input-group">
                    <input type="text" id="chatInput" placeholder="Digite sua mensagem">
                    <button id="sendBtn">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Atualiza a visibilidade do chat e a largura da sidebar com base no estado salvo
    function updateChatVisibility() {
        const chatContainer = document.getElementById("chatContainer");
        const sidebar = document.getElementById("sidebar");
        if (localStorage.getItem("chatOpen") === "true") {
            chatContainer.style.display = "block";
            sidebar.style.width = "390px";
            // Atualiza o conteúdo principal para acompanhar a nova largura da sidebar
            document.getElementById("main-content").style.marginLeft = "390px";
            document.getElementById("main-content").style.width = "calc(100% - 390px)";
        } else {
            chatContainer.style.display = "none";
            sidebar.style.width = "250px";
            document.getElementById("main-content").style.marginLeft = "250px";
            document.getElementById("main-content").style.width = "calc(100% - 250px)";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        updateChatVisibility();

        // Ao clicar no botão Chat IA, alterna o estado (abre/fecha), atualiza a largura da sidebar e salva no localStorage
        document.getElementById("chatToggle").addEventListener("click", function() {
            const chatContainer = document.getElementById("chatContainer");
            const sidebar = document.getElementById("sidebar");
            const mainContent = document.getElementById("main-content");
            const isVisible = (chatContainer.style.display === "block");
            if (isVisible) {
                chatContainer.style.display = "none";
                sidebar.style.width = "250px";
                mainContent.style.marginLeft = "250px";
                mainContent.style.width = "calc(100% - 250px)";
                localStorage.setItem("chatOpen", "false");
            } else {
                chatContainer.style.display = "block";
                sidebar.style.width = "390px";
                mainContent.style.marginLeft = "390px";
                mainContent.style.width = "calc(100% - 390px)";
                localStorage.setItem("chatOpen", "true");
            }
        });

        // Fecha o chat quando clicar no "X" e atualiza o estado e largura da sidebar
        document.getElementById("chatClose").addEventListener("click", function() {
            const chatContainer = document.getElementById("chatContainer");
            const sidebar = document.getElementById("sidebar");
            const mainContent = document.getElementById("main-content");
            chatContainer.style.display = "none";
            sidebar.style.width = "250px";
            mainContent.style.marginLeft = "250px";
            mainContent.style.width = "calc(100% - 250px)";
            localStorage.setItem("chatOpen", "false");
        });

        // Exemplo simples de envio de mensagem (apenas frontend)
        document.getElementById("sendBtn").addEventListener("click", function() {
            const input = document.getElementById("chatInput");
            const msg = input.value.trim();
            if (msg !== "") {
                const messages = document.getElementById("chatMessages");
                const userMsg = document.createElement("div");
                userMsg.innerHTML = "<strong>Você:</strong> " + msg;
                messages.appendChild(userMsg);
                input.value = "";
                messages.scrollTop = messages.scrollHeight;

                // Enviar a mensagem para a API de chat via GET
                fetch(`http://127.0.0.1:8001/chat/${encodeURIComponent(msg)}`, {
                        method: 'GET'
                    , })
                    .then(response => response.text()) // Tratando a resposta como texto
                    .then(data => {
                        // Exibir a resposta da API no chat
                        const aiMsg = document.createElement("div");
                        aiMsg.innerHTML = "<strong>IA:</strong> " + data;
                        messages.appendChild(aiMsg);
                        messages.scrollTop = messages.scrollHeight;
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            }
        });


    });

</script>
