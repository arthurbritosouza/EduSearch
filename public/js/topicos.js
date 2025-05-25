$(document).ready(function() {
    console.log('Tópicos JS carregado com sucesso');
    
    // ===== INICIALIZAÇÃO =====
    initializeExerciseModals();
    initializeReadingFeatures();
    initializeFontControls();
    initializeNoteFeatures();
    initializeSidebarToggle();
    
    // ===== MODAIS DE EXERCÍCIOS (CORRIGIDO PARA BOOTSTRAP 5) =====
    
    // Abrir modal de exercício
    $(document).on('click', '.open-exercise-modal', function() {
        var exerciseId = $(this).data('exercise-id');
        openExerciseModal(exerciseId);
    });

    // Fechar modal de exercício
    $(document).on('click', '.close-modal', function() {
        var exerciseId = $(this).data('exercise-id');
        closeExerciseModal(exerciseId);
    });

    // Fechar modal de feedback
    $(document).on('click', '.close-feedback-modal', function() {
        var exerciseId = $(this).data('exercise-id');
        closeFeedbackModal(exerciseId);
    });

    // Enviar resposta
    $(document).on('click', '.submit-answer', function() {
        var exerciseId = $(this).data('exercise-id');
        submitAnswer(exerciseId);
    });

    // Garantir limpeza adequada ao fechar qualquer modal
    $(document).on('hidden.bs.modal', '.modal', function() {
        cleanupModals();
    });
});

// ===== FUNÇÕES DOS EXERCÍCIOS (CORRIGIDAS PARA BOOTSTRAP 5) =====

function openExerciseModal(exerciseId) {
    // Fechar qualquer modal aberto primeiro
    $('.modal').each(function() {
        var modalInstance = bootstrap.Modal.getInstance(this);
        if (modalInstance) {
            modalInstance.hide();
        }
    });
    
    // Limpar qualquer resíduo de modal
    cleanupModals();
    
    // Aguardar um momento antes de abrir o novo modal
    setTimeout(function() {
        var modalElement = document.getElementById('modal-' + exerciseId);
        if (modalElement) {
            var modal = new bootstrap.Modal(modalElement);
            modal.show();
        }
    }, 300);
}

function closeExerciseModal(exerciseId) {
    var modalElement = document.getElementById('modal-' + exerciseId);
    if (modalElement) {
        var modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        }
    }
    cleanupModals();
}

function closeFeedbackModal(exerciseId) {
    var modalElement = document.getElementById('feedback-modal-' + exerciseId);
    if (modalElement) {
        var modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        }
    }
    cleanupModals();
}

function cleanupModals() {
    setTimeout(function() {
        // Remover todos os backdrops
        $('.modal-backdrop').remove();
        
        // Remover classes do body
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
        $('body').css('overflow', '');
        
        // Garantir que todos os modais estejam ocultos
        $('.modal').removeClass('show').css('display', 'none');
        $('.modal').attr('aria-hidden', 'true');
        $('.modal').removeAttr('aria-modal');
    }, 100);
}

function submitAnswer(exerciseId) {
    let form = document.getElementById('answerForm-' + exerciseId);
    let formData = new FormData(form);

    // Verificar se uma resposta foi selecionada
    let respostaSelecionada = form.querySelector('input[name="resposta"]:checked');
    if (!respostaSelecionada) {
        alert('Por favor, selecione uma resposta.');
        return;
    }

    // Mostrar loading no botão
    const submitBtn = document.querySelector(`.submit-answer[data-exercise-id="${exerciseId}"]`);
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Verificando...';
    submitBtn.disabled = true;

    fetch('/verificar-resposta', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        let feedbackMessage = document.getElementById('feedback-message-' + exerciseId);
        let resolucaoText = document.getElementById('resolucao-' + exerciseId);

        // Define a classe do alerta conforme o resultado
        if (data.resultado === 'correto') {
            feedbackMessage.className = 'alert alert-success';
        } else {
            feedbackMessage.className = 'alert alert-danger';
        }
        feedbackMessage.innerText = data.mensagem;
        resolucaoText.innerText = data.resolucao;

        // Fechar o modal de exercício
        closeExerciseModal(exerciseId);

        // Esperar antes de abrir o modal de feedback
        setTimeout(function() {
            var feedbackModalElement = document.getElementById('feedback-modal-' + exerciseId);
            if (feedbackModalElement) {
                var feedbackModal = new bootstrap.Modal(feedbackModalElement);
                feedbackModal.show();
            }
        }, 500);
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Ocorreu um erro ao enviar a resposta.');
    })
    .finally(() => {
        // Restaurar botão
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// ===== INICIALIZAÇÃO DOS MODAIS DE EXERCÍCIOS =====
function initializeExerciseModals() {
    // Configurações adicionais se necessário
    console.log('Modais de exercícios inicializados');
    
    // Garantir que todos os modais tenham os event listeners corretos
    document.querySelectorAll('.exercise-modal').forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            cleanupModals();
        });
    });
}

// ===== RECURSOS DE LEITURA =====
function initializeReadingFeatures() {
    // Gerar índice automaticamente
    generateTableOfContents();
    
    // Calcular tempo de leitura
    calculateReadingTime();
    
    // Configurar barra de progresso
    setupReadingProgress();
    
    // Modo leitura
    setupReadingMode();
    
    // Toggle índice
    setupTocToggle();
}

function generateTableOfContents() {
    const content = document.getElementById('articleContent');
    const tocContent = document.getElementById('tocContent');
    
    if (!content || !tocContent) return;
    
    const headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6');
    
    if (headings.length === 0) {
        tocContent.innerHTML = '<p class="text-muted">Nenhum título encontrado</p>';
        return;
    }
    
    let tocHTML = '';
    headings.forEach((heading, index) => {
        const id = `heading-${index}`;
        heading.id = id;
        const level = parseInt(heading.tagName.charAt(1));
        const indent = (level - 1) * 15;
        
        tocHTML += `
            <a href="#${id}" class="toc-link" style="margin-left: ${indent}px;">
                ${heading.textContent}
            </a>
        `;
    });
    
    tocContent.innerHTML = tocHTML;
    
    // Smooth scroll para links do índice
    document.querySelectorAll('.toc-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

function calculateReadingTime() {
    const content = document.getElementById('articleContent');
    const readingTimeElement = document.getElementById('readingTime');
    
    if (!content || !readingTimeElement) return;
    
    const text = content.textContent || content.innerText;
    const wordsPerMinute = 200;
    const words = text.trim().split(/\s+/).length;
    const readingTime = Math.ceil(words / wordsPerMinute);
    
    readingTimeElement.textContent = `${readingTime} min`;
}

function setupReadingProgress() {
    const progressBar = document.getElementById('readingProgressBar');
    const content = document.getElementById('articleContent');
    
    if (!progressBar || !content) return;
    
    window.addEventListener('scroll', function() {
        const contentTop = content.offsetTop;
        const contentHeight = content.offsetHeight;
        const windowHeight = window.innerHeight;
        const scrollTop = window.pageYOffset;
        
        const totalScrollable = contentHeight - windowHeight;
        const scrolled = scrollTop - contentTop;
        
        if (scrolled <= 0) {
            progressBar.style.width = '0%';
        } else if (scrolled >= totalScrollable) {
            progressBar.style.width = '100%';
        } else {
            const progress = (scrolled / totalScrollable) * 100;
            progressBar.style.width = `${progress}%`;
        }
    });
}

function setupReadingMode() {
    const readingModeBtn = document.getElementById('readingMode');
    const contentReader = document.querySelector('.content-reader');
    
    if (!readingModeBtn || !contentReader) return;
    
    readingModeBtn.addEventListener('click', function() {
        contentReader.classList.toggle('reading-mode');
        
        if (contentReader.classList.contains('reading-mode')) {
            this.innerHTML = '<i class="bi bi-x-circle"></i> Sair do Modo Leitura';
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-secondary');
        } else {
            this.innerHTML = '<i class="bi bi-eye"></i> Modo Leitura';
            this.classList.remove('btn-secondary');
            this.classList.add('btn-outline-secondary');
        }
    });
}

function setupTocToggle() {
    const toggleBtn = document.getElementById('toggleToc');
    const tocSidebar = document.getElementById('tocSidebar');
    
    if (!toggleBtn || !tocSidebar) return;
    
    toggleBtn.addEventListener('click', function() {
        if (tocSidebar.style.display === 'none') {
            tocSidebar.style.display = 'block';
            this.innerHTML = '<i class="bi bi-list"></i> Ocultar Índice';
        } else {
            tocSidebar.style.display = 'none';
            this.innerHTML = '<i class="bi bi-list"></i> Mostrar Índice';
        }
    });
}

// ===== CONTROLES DE FONTE =====
function initializeFontControls() {
    const decreaseBtn = document.getElementById('decreaseFont');
    const increaseBtn = document.getElementById('increaseFont');
    const articleBody = document.querySelector('.article-body');
    
    if (!decreaseBtn || !increaseBtn || !articleBody) return;
    
    let currentSize = 14; // Tamanho base em px
    
    decreaseBtn.addEventListener('click', function() {
        if (currentSize > 12) {
            currentSize -= 1;
            articleBody.style.fontSize = `${currentSize}px`;
        }
    });
    
    increaseBtn.addEventListener('click', function() {
        if (currentSize < 20) {
            currentSize += 1;
            articleBody.style.fontSize = `${currentSize}px`;
        }
    });
}

// ===== RECURSOS DE ANOTAÇÕES =====
function initializeNoteFeatures() {
    // Botões de visualização em tela cheia
    document.querySelectorAll('.btn-fullscreen').forEach(button => {
        button.addEventListener('click', function() {
            const noteCard = this.closest('.note-card');
            toggleFullscreenNote(noteCard);
        });
    });
    
    // Botões de visualização em popup
    document.querySelectorAll('.btn-view').forEach(button => {
        button.addEventListener('click', function() {
            const noteCard = this.closest('.note-card');
            const noteTitle = noteCard.querySelector('.note-title').textContent;
            const noteContent = noteCard.querySelector('.note-content').innerHTML;
            
            // Preencher o modal de visualização
            const viewModalLabel = document.getElementById('viewNoteModalLabel');
            const viewModalContent = document.getElementById('viewNoteContent');
            
            if (viewModalLabel) viewModalLabel.textContent = noteTitle;
            if (viewModalContent) viewModalContent.innerHTML = noteContent;
        });
    });
}

function toggleFullscreenNote(noteCard) {
    if (noteCard.classList.contains('fullscreen-note')) {
        // Sair do modo tela cheia
        noteCard.classList.remove('fullscreen-note');
        document.body.classList.remove('note-fullscreen-active');
        
        // Remover botão de fechar se existir
        const closeBtn = noteCard.querySelector('.fullscreen-close');
        if (closeBtn) {
            closeBtn.remove();
        }
    } else {
        // Entrar no modo tela cheia
        noteCard.classList.add('fullscreen-note');
        document.body.classList.add('note-fullscreen-active');
        
        // Adicionar botão de fechar
        if (!noteCard.querySelector('.fullscreen-close')) {
            const closeBtn = document.createElement('button');
            closeBtn.className = 'btn btn-sm btn-outline-secondary fullscreen-close';
            closeBtn.innerHTML = '<i class="bi bi-x-lg"></i> Fechar';
            closeBtn.onclick = () => toggleFullscreenNote(noteCard);
            
            noteCard.querySelector('.note-actions').appendChild(closeBtn);
        }
    }
}

// ===== SIDEBAR TOGGLE (SEU CÓDIGO ORIGINAL) =====
function initializeSidebarToggle() {
    // Toggle sidebar em dispositivos móveis
    const sidebarCollapse = document.getElementById('sidebarCollapse');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const overlay = document.getElementById('overlay');

    if (sidebarCollapse) {
        sidebarCollapse.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active');
            overlay.classList.toggle('active');
        });
    }

    // Fechar sidebar quando clicar no overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    // Responsividade para dispositivos móveis
    function checkWidth() {
        if (window.innerWidth <= 991.98) {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
            overlay.classList.remove('active');
        } else {
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
            overlay.classList.remove('active');
        }
    }

    window.addEventListener('resize', checkWidth);
    checkWidth();
}

// ===== FILTROS =====
document.addEventListener('change', function(e) {
    if (e.target.id === 'levelFilter') {
        filterExercisesByLevel(e.target.value);
    }
});

function filterExercisesByLevel(level) {
    const exerciseCards = document.querySelectorAll('.exercise-card');
    
    exerciseCards.forEach(card => {
        if (level === '' || card.getAttribute('data-level') === level) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// ===== INICIALIZAÇÃO DE OUTROS MODAIS =====
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todos os modais do Bootstrap 5
    var modalElements = document.querySelectorAll('.modal');
    modalElements.forEach(function(modalElement) {
        // Garantir que cada modal tenha uma instância Bootstrap
        modalElement.addEventListener('show.bs.modal', function() {
            console.log('Modal sendo aberto:', modalElement.id);
        });
        
        modalElement.addEventListener('hidden.bs.modal', function() {
            console.log('Modal fechado:', modalElement.id);
            cleanupModals();
        });
    });
});

// ===== SMOOTH SCROLL GLOBAL =====
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('toc-link') || e.target.closest('.toc-link')) {
        e.preventDefault();
        const link = e.target.classList.contains('toc-link') ? e.target : e.target.closest('.toc-link');
        const targetId = link.getAttribute('href').substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
});

// ===== UTILITÁRIOS =====
function showLoading(element, text = 'Carregando...') {
    element.innerHTML = `<i class="bi bi-hourglass-split me-2"></i>${text}`;
    element.disabled = true;
}

function hideLoading(element, originalText) {
    element.innerHTML = originalText;
    element.disabled = false;
}

// ===== LOG DE DEBUG =====
console.log('JavaScript dos tópicos carregado completamente');
