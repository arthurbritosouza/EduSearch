document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Iniciando upload de PDFs...');
    
    // Verificar se todos os elementos existem
    const elements = {
        processTypeSelect: document.getElementById('processType'),
        pdfFilesInput: document.getElementById('pdfFiles'),
        filePreview: document.getElementById('filePreview'),
        fileList: document.getElementById('fileList'),
        combinedTitleField: document.getElementById('combinedTitleField'),
        separateTitlesField: document.getElementById('separateTitlesField'),
        titleInputs: document.getElementById('titleInputs'),
        uploadForm: document.getElementById('pdfUploadForm'),
        uploadBtn: document.getElementById('uploadBtn')
    };

    // Verificar se todos os elementos foram encontrados
    for (const [key, element] of Object.entries(elements)) {
        if (!element) {
            console.error(`❌ Elemento não encontrado: ${key}`);
            return;
        }
    }

    console.log('✅ Todos os elementos encontrados');
    
    let selectedFiles = [];

    // Mudança no tipo de processamento
    elements.processTypeSelect.addEventListener('change', function() {
        const processType = this.value;
        console.log('📋 Tipo de processamento selecionado:', processType);
        
        if (processType === 'combined') {
            elements.combinedTitleField.style.display = 'block';
            elements.separateTitlesField.style.display = 'none';
            const combinedTitle = document.getElementById('combinedTitle');
            if (combinedTitle) combinedTitle.required = true;
        } else if (processType === 'separate') {
            elements.combinedTitleField.style.display = 'none';
            elements.separateTitlesField.style.display = 'block';
            const combinedTitle = document.getElementById('combinedTitle');
            if (combinedTitle) combinedTitle.required = false;
            generateTitleInputs();
        } else {
            elements.combinedTitleField.style.display = 'none';
            elements.separateTitlesField.style.display = 'none';
            const combinedTitle = document.getElementById('combinedTitle');
            if (combinedTitle) combinedTitle.required = false;
        }
    });

    // Seleção de arquivos
    elements.pdfFilesInput.addEventListener('change', function() {
        selectedFiles = Array.from(this.files);
        console.log('📁 Arquivos selecionados:', selectedFiles.length);
        updateFilePreview();
        
        if (elements.processTypeSelect.value === 'separate') {
            generateTitleInputs();
        }
    });

    // Atualizar preview dos arquivos
    function updateFilePreview() {
        if (selectedFiles.length === 0) {
            elements.filePreview.style.display = 'none';
            return;
        }

        elements.filePreview.style.display = 'block';
        elements.fileList.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item mb-2 p-2 border rounded';
            fileItem.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>
                        <strong>${file.name}</strong>
                        <small class="text-muted d-block">${formatFileSize(file.size)}</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile(${index})">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            `;
            elements.fileList.appendChild(fileItem);
        });
    }

    // Gerar inputs de título para PDFs separados
    function generateTitleInputs() {
        if (selectedFiles.length === 0) {
            elements.titleInputs.innerHTML = '<p class="text-muted">Selecione os PDFs primeiro</p>';
            return;
        }

        elements.titleInputs.innerHTML = '';
        
        selectedFiles.forEach((file, index) => {
            const titleGroup = document.createElement('div');
            titleGroup.className = 'mb-3 p-3 border rounded';
            titleGroup.innerHTML = `
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>
                    <strong>${file.name}</strong>
                </div>
                <input type="text" class="form-control" name="pdf_titles[]" 
                       placeholder="Título para este PDF..." required>
            `;
            elements.titleInputs.appendChild(titleGroup);
        });
    }

    // Remover arquivo
    window.removeFile = function(index) {
        console.log('🗑️ Removendo arquivo:', index);
        selectedFiles.splice(index, 1);
        
        // Atualizar o input file
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        elements.pdfFilesInput.files = dt.files;
        
        updateFilePreview();
        
        if (elements.processTypeSelect.value === 'separate') {
            generateTitleInputs();
        }
    };

    // Formatar tamanho do arquivo
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Validação e envio do formulário
    elements.uploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('📤 Formulário sendo enviado...');
        
        // Validações
        if (selectedFiles.length === 0) {
            alert('Por favor, selecione pelo menos um arquivo PDF.');
            return;
        }

        if (selectedFiles.length > 10) {
            alert('Máximo de 10 arquivos permitidos.');
            return;
        }

        // Verificar tamanho dos arquivos
        const maxSize = 50 * 1024 * 1024; // 50MB
        const oversizedFiles = selectedFiles.filter(file => file.size > maxSize);
        if (oversizedFiles.length > 0) {
            alert(`Os seguintes arquivos excedem 50MB: ${oversizedFiles.map(f => f.name).join(', ')}`);
            return;
        }

        // Verificar se todos os PDFs têm título (modo separado)
        if (elements.processTypeSelect.value === 'separate') {
            const titleInputsElements = elements.titleInputs.querySelectorAll('input[name="pdf_titles[]"]');
            const emptyTitles = Array.from(titleInputsElements).filter(input => !input.value.trim());
            
            if (emptyTitles.length > 0) {
                alert('Por favor, preencha o título para todos os PDFs.');
                emptyTitles[0].focus();
                return;
            }
        }

        // Verificar título combinado
        if (elements.processTypeSelect.value === 'combined') {
            const combinedTitle = document.getElementById('combinedTitle');
            if (!combinedTitle || !combinedTitle.value.trim()) {
                alert('Por favor, preencha o título da base de conhecimento.');
                if (combinedTitle) combinedTitle.focus();
                return;
            }
        }

        // Enviar formulário
        submitForm();
    });

    // Função para enviar o formulário
    async function submitForm() {
        const formData = new FormData(elements.uploadForm);
        const originalText = elements.uploadBtn.innerHTML;
        
        try {
            console.log('🔄 Enviando dados para o servidor...');
            
            // Mostrar loading
            elements.uploadBtn.disabled = true;
            elements.uploadBtn.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>Processando...';

            // Obter CSRF token de forma mais robusta
            let csrfToken = '';
            const metaToken = document.querySelector('meta[name="csrf-token"]');
            const inputToken = document.querySelector('input[name="_token"]');
            
            if (metaToken) {
                csrfToken = metaToken.getAttribute('content');
            } else if (inputToken) {
                csrfToken = inputToken.value;
            } else {
                throw new Error('CSRF token não encontrado');
            }

            console.log('🔐 CSRF Token encontrado');

            const response = await fetch('/upload_pdfs', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            console.log('📡 Resposta do servidor:', response.status);

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || `Erro ${response.status}: ${response.statusText}`);
            }

            // Sucesso
            console.log('✅ Upload realizado com sucesso');
            alert('PDFs enviados com sucesso! Eles serão processados pela IA.');
            
            // Reset form
            elements.uploadForm.reset();
            selectedFiles = [];
            updateFilePreview();
            elements.combinedTitleField.style.display = 'none';
            elements.separateTitlesField.style.display = 'none';
            
            // Fechar modal se existir
            const modal = document.getElementById('pdfUploadModal');
            if (modal && typeof bootstrap !== 'undefined') {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                if (modalInstance) modalInstance.hide();
            }

        } catch (error) {
            console.error('❌ Erro no upload:', error);
            alert(error.message || 'Erro ao enviar arquivos. Tente novamente.');
        } finally {
            // Reset button
            elements.uploadBtn.disabled = false;
            elements.uploadBtn.innerHTML = originalText;
        }
    }

    console.log('✅ JavaScript do upload de PDFs carregado com sucesso');
});
