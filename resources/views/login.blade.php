<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" sizes="32x32" href="{{ asset('logo_edusearch.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Estudos - Login e Cadastro</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a73e8, #0f4c81);
            overflow: hidden;
        }

        .container {
            position: relative;
            width: 100%;
            max-width: 850px;
            height: 600px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .form-box {
            display: flex;
            width: 100%;
            height: 100%;
        }

        .form-container {
            width: 50%;
            padding: 0 40px;
            position: relative;
            z-index: 10;
        }

        .slide-controls {
            position: relative;
            display: flex;
            margin: 30px 0;
            height: 50px;
            width: 100%;
            overflow: hidden;
            border-radius: 10px;
            background-color: #f1f8ff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .slide-controls .slide {
            height: 100%;
            width: 50%;
            color: #0d47a1;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .slide-controls .slider-tab {
            position: absolute;
            height: 100%;
            width: 50%;
            left: 0;
            z-index: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, #2196f3, #0d47a1);
            transition: all 0.3s ease;
        }

        /* Escondendo os radios */
        .slide-controls input {
            display: none;
        }

        /* Alteração visual dos labels */
        #signup:checked~.slider-tab {
            left: 50%;
        }

        #signup:checked~.slide.login {
            color: #000;
        }

        #signup:checked~.slide.signup {
            color: #fff;
        }

        #login:checked~.slide.signup {
            color: #000;
        }

        #login:checked~.slide.login {
            color: #fff;
        }

        /* Apenas um formulário é exibido por vez */
        .form-inner {
            position: relative;
        }

        .form-inner form {
            display: none;
        }

        .form-inner form.active {
            display: block;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            color: #0d47a1;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .logo i {
            font-size: 2rem;
            margin-right: 10px;
        }

        .field {
            position: relative;
            height: 60px;
            width: 100%;
            margin-bottom: 15px;
        }

        .input-icon {
            position: relative;
            height: 50px;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            color: #0d47a1;
            font-size: 18px;
        }

        .input-icon .toggle-password {
            left: auto;
            right: 15px;
            cursor: pointer;
        }

        .field input {
            height: 100%;
            width: 100%;
            outline: none;
            padding: 0 45px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .field input:focus {
            border-color: #2196f3;
            box-shadow: 0 0 8px rgba(33, 150, 243, 0.3);
        }

        .error-message {
            color: #e53935;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .pass-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
        }

        .checkbox-wrapper input {
            margin-right: 5px;
        }

        .pass-link a {
            color: #2196f3;
            text-decoration: none;
        }

        .pass-link a:hover {
            text-decoration: underline;
        }

        .btn-field {
            height: 50px;
            margin-top: 10px;
        }

        .btn-field button {
            height: 100%;
            width: 100%;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #2196f3, #0d47a1);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-field button:hover {
            background: linear-gradient(135deg, #0d47a1, #2196f3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33, 150, 243, 0.4);
        }

        /* Estilos da imagem */
        .image-container {
            width: 50%;
            background: linear-gradient(135deg, #2196f3, #0d47a1);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
            z-index: 5;
        }

        .image-content {
            color: white;
            text-align: center;
            z-index: 1;
        }

        .image-content h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .image-content p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* Elementos flutuantes melhorados */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .float-element {
            position: absolute;
            color: rgba(255, 255, 255, 0.3);
            font-size: 2.5rem;
            animation: float 6s infinite ease-in-out;
        }

        /* Posicionamento específico para cada elemento */
        .book {
            top: 15%;
            left: 20%;
            font-size: 3rem;
            animation-delay: 0s;
        }

        .pencil {
            top: 70%;
            left: 25%;
            font-size: 2.8rem;
            animation-delay: 1s;
        }

        .calculator {
            top: 40%;
            right: 15%;
            font-size: 2.6rem;
            animation-delay: 2s;
        }

        .bulb {
            top: 20%;
            right: 20%;
            font-size: 2.7rem;
            animation-delay: 3s;
        }

        .brain {
            top: 80%;
            right: 25%;
            font-size: 3.2rem;
            animation-delay: 4s;
        }

        /* Novos elementos adicionados */
        .notebook {
            top: 50%;
            left: 10%;
            font-size: 2.8rem;
            animation-delay: 1.5s;
        }

        .globe {
            top: 30%;
            left: 40%;
            font-size: 3rem;
            animation-delay: 2.5s;
        }

        .graduation {
            top: 60%;
            right: 10%;
            font-size: 2.9rem;
            animation-delay: 3.5s;
        }

        .atom {
            top: 10%;
            right: 40%;
            font-size: 2.7rem;
            animation-delay: 4.5s;
        }

        .ruler {
            bottom: 15%;
            left: 40%;
            font-size: 2.6rem;
            animation-delay: 5s;
        }

        /* Animação melhorada */
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 0.3;
            }

            25% {
                transform: translateY(-15px) rotate(5deg) scale(1.05);
                opacity: 0.5;
            }

            50% {
                transform: translateY(-25px) rotate(10deg) scale(1.1);
                opacity: 0.7;
            }

            75% {
                transform: translateY(-15px) rotate(5deg) scale(1.05);
                opacity: 0.5;
            }

            100% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 0.3;
            }
        }

        /* Efeito de partículas */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .particle {
            position: absolute;
            width: 5px;
            height: 5px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: particle-float 15s infinite linear;
        }

        @keyframes particle-float {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }

            10% {
                opacity: 0.5;
            }

            90% {
                opacity: 0.5;
            }

            100% {
                transform: translateY(-300px) translateX(100px);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            .container {
                max-width: 400px;
                height: auto;
            }

            .form-box {
                flex-direction: column-reverse;
            }

            .form-container,
            .image-container {
                width: 100%;
            }

            .image-container {
                height: 200px;
                padding: 20px;
            }

            .image-content h2 {
                font-size: 1.5rem;
            }

            .image-content p {
                font-size: 0.9rem;
                margin-bottom: 10px;
            }

            .form-container {
                padding: 20px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <div class="form-container">
                <div class="slide-controls">
                    <!-- Radios para alternar -->
                    <input type="radio" name="slide" id="login" checked>
                    <input type="radio" name="slide" id="signup">
                    <label for="login" class="slide login">Login</label>
                    <label for="signup" class="slide signup">Cadastro</label>
                    <div class="slider-tab"></div>
                </div>
                <div class="form-inner">
                    <!-- Formulário de Login -->
                    <form action="/login_form" method="POST" id="login-form" class="login-form active">
                        @csrf
                        <div class="logo">
                            <i class="bx bx-book-reader"></i>
                            <span>Portal de Estudos</span>
                        </div>
                        <div class="field">
                            <div class="input-icon">
                                <i class="bx bx-user"></i>
                                <input type="text" id="login-email" name="email" placeholder="Email ou Usuário" required>
                            </div>
                            <span class="error-message"></span>
                        </div>
                        <div class="field">
                            <div class="input-icon">
                                <i class="bx bx-lock-alt"></i>
                                <input type="password" id="login-password" name="password" placeholder="Senha" required>
                                <i class="bx bx-show toggle-password"></i>
                            </div>
                            <span class="error-message"></span>
                        </div>
                        <div class="pass-link">
                            <div class="checkbox-wrapper">
                                <input type="checkbox" id="remember">
                                <label for="remember">Lembrar-me</label>
                            </div>
                            <a href="#">Esqueceu a senha?</a>
                        </div>
                        <div class="field btn-field">
                            <button type="submit">ENTRAR</button>
                        </div>
                    </form>
                    <!-- Formulário de Cadastro -->
                    <form action="{{ route('login.store') }}" method="POST" id="signup-form" class="signup-form">
                        @csrf
                        <div class="logo">
                            <i class="bx bx-book-reader"></i>
                            <span>Junte-se a nós</span>
                        </div>
                        <div class="field">
                            <div class="input-icon">
                                <i class="bx bx-user"></i>
                                <input type="text" id="signup-name" name="name" placeholder="Nome completo" required>
                            </div>
                            <span class="error-message"></span>
                        </div>
                        <div class="field">
                            <div class="input-icon">
                                <i class="bx bx-envelope"></i>
                                <input type="email" id="signup-email" name="email" placeholder="Email" required>
                            </div>
                            <span class="error-message"></span>
                        </div>
                        <div class="field">
                            <div class="input-icon">
                                <i class="bx bx-lock-alt"></i>
                                <input type="password" id="signup-password" name="password" placeholder="Senha" required>
                                <i class="bx bx-show toggle-password"></i>
                            </div>
                            <span class="error-message"></span>
                        </div>
                        <div class="field">
                            <span class="error-message"></span>
                        </div>
                        <div class="field btn-field">
                            <button type="submit">CADASTRAR</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="image-container">
                <div class="image-content">
                    <h2 id="welcome-text">Bem-vindo de volta!</h2>
                    <p id="welcome-desc">Continue sua jornada de aprendizado e alcance novos horizontes acadêmicos.</p>
                    <div class="floating-elements">
                        <!-- Elementos originais -->
                        <div class="float-element book"><i class="bx bx-book"></i></div>
                        <div class="float-element pencil"><i class="bx bx-pencil"></i></div>
                        <div class="float-element calculator"><i class="bx bx-calculator"></i></div>
                        <div class="float-element bulb"><i class="bx bx-bulb"></i></div>
                        <div class="float-element brain"><i class="bx bx-brain"></i></div>

                        <!-- Novos elementos adicionados -->
                        <div class="float-element notebook"><i class="bx bx-notepad"></i></div>
                        <div class="float-element globe"><i class="bx bx-globe"></i></div>
                        <div class="float-element graduation"><i class="bx bx-graduation"></i></div>
                        <div class="float-element atom"><i class="bx bx-atom"></i></div>
                        <div class="float-element ruler"><i class="bx bx-ruler"></i></div>
                    </div>

                    <!-- Efeito de partículas -->
                    <div class="particles" id="particles"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alternar visibilidade das senhas
            const togglePasswordButtons = document.querySelectorAll('.toggle-password');
            togglePasswordButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.classList.toggle('bx-show');
                    this.classList.toggle('bx-hide');
                });
            });

            // Alternar entre formulários de Login e Cadastro via radio buttons
            const loginRadio = document.getElementById('login');
            const signupRadio = document.getElementById('signup');
            const loginForm = document.getElementById('login-form');
            const signupForm = document.getElementById('signup-form');

            function updateForms() {
                if (loginRadio.checked) {
                    loginForm.classList.add('active');
                    signupForm.classList.remove('active');
                    document.getElementById('welcome-text').textContent = 'Bem-vindo de volta!';
                    document.getElementById('welcome-desc').textContent = 'Continue sua jornada de aprendizado e alcance novos horizontes acadêmicos.';
                } else if (signupRadio.checked) {
                    signupForm.classList.add('active');
                    loginForm.classList.remove('active');
                    document.getElementById('welcome-text').textContent = 'Junte-se a nós!';
                    document.getElementById('welcome-desc').textContent = 'Comece sua jornada de aprendizado hoje e transforme seu futuro acadêmico.';
                }
            }
            loginRadio.addEventListener('change', updateForms);
            signupRadio.addEventListener('change', updateForms);
            updateForms();

            // Validação do formulário de Login
            const loginFormEl = document.getElementById('login-form');
            loginFormEl.addEventListener('submit', function(e) {
                let isValid = true;
                const loginEmail = document.getElementById('login-email');
                const loginPassword = document.getElementById('login-password');

                if (loginEmail.value.trim() === '') {
                    loginEmail.nextElementSibling.textContent = 'Por favor, informe seu email ou usuário';
                    isValid = false;
                } else {
                    loginEmail.nextElementSibling.textContent = '';
                }
                if (loginPassword.value.trim() === '') {
                    loginPassword.nextElementSibling.textContent = 'Por favor, informe sua senha';
                    isValid = false;
                } else {
                    loginPassword.nextElementSibling.textContent = '';
                }
                // Se não for válido, previne o envio; caso contrário, permite o envio natural do formulário.
                if (!isValid) {
                    e.preventDefault();
                } else {
                    // Se desejar exibir uma mensagem antes do envio, descomente a linha abaixo.
                    // alert('Login realizado com sucesso!');
                }
            });

            // Validação do formulário de Cadastro
            const signupFormEl = document.getElementById('signup-form');
            signupFormEl.addEventListener('submit', function(e) {
                let isValid = true;
                const signupName = document.getElementById('signup-name');
                const signupEmail = document.getElementById('signup-email');
                const signupPassword = document.getElementById('signup-password');

                if (signupName.value.trim() === '') {
                    signupName.nextElementSibling.textContent = 'Por favor, informe seu nome completo';
                    isValid = false;
                } else {
                    signupName.nextElementSibling.textContent = '';
                }
                if (signupEmail.value.trim() === '') {
                    signupEmail.nextElementSibling.textContent = 'Por favor, informe seu email';
                    isValid = false;
                } else {
                    signupEmail.nextElementSibling.textContent = '';
                }
                if (signupPassword.value.trim() === '') {
                    signupPassword.nextElementSibling.textContent = 'Por favor, crie uma senha';
                    isValid = false;
                } else if (signupPassword.value.length < 6) {
                    signupPassword.nextElementSibling.textContent = 'A senha deve ter pelo menos 6 caracteres';
                    isValid = false;
                } else {
                    signupPassword.nextElementSibling.textContent = '';
                }
                if (!isValid) {
                    e.preventDefault();
                } else {
                    // Se desejar exibir uma mensagem antes do envio, descomente a linha abaixo.
                    alert('Cadastro realizado com sucesso!');
                }
            });

            // Criar partículas para o fundo
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 20; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.width = Math.random() * 4 + 2 + 'px';
                particle.style.height = particle.style.width;
                particle.style.animationDelay = Math.random() * 5 + 's';
                particle.style.animationDuration = Math.random() * 10 + 10 + 's';
                particlesContainer.appendChild(particle);
            }
        });

    </script>
</body>
</html>
