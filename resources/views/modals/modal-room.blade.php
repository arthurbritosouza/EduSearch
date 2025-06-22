<!-- Modal: Adicionar Novo Membro -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel"><i class="bi bi-person-plus-fill me-2"></i>Convidar para a Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('create_notification')}}" method="POST">
                    @csrf
                    <input type="hidden" name="room_id" value="{{$room->id}}">
                    <input type="hidden" name="type" value=2>
                    <div class="mb-3">
                        <label for="memberEmail" class="form-label">E-mail do Convidado</label>
                        <input type="email" class="form-control" name="email" placeholder="exemplo@email.com" required>
                    </div>
                    <div class="alert alert-info d-flex align-items-center mt-3" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <div>
                            O usuário receberá um convite por e-mail para se juntar à sala.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="addMemberForm" class="btn btn-primary"><i class="bi bi-send me-1"></i>Enviar Convite</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Editar Sala -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('room.update', $room->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="roomName" class="form-label">Nome da Sala</label>
                        <input type="text" class="form-control" id="roomName" name="name" value="{{ $room->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="roomDescription" class="form-label">Descrição</label>
                        <textarea class="form-control" id="roomDescription" name="description" rows="3" required>{{ $room->description }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Adicionar Tópico -->
<div class="modal fade" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTopicModalLabel"><i class="bi bi-bookmarks-fill me-2"></i>Adicionar Tópico à Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Navegação por Abas no Modal -->
                <ul class="nav nav-tabs" id="topicTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="my-topics-tab" data-bs-toggle="tab" data-bs-target="#my-topics" type="button" role="tab">
                            Meus Tópicos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="create-topic-tab" data-bs-toggle="tab" data-bs-target="#create-topic" type="button" role="tab">
                            Criar Novo Tópico
                        </button>
                    </li>
                </ul>
                <!-- Conteúdo das Abas -->
                <div class="tab-content mt-3" id="topicTabsContent">
                    <!-- Aba Meus Tópicos -->
                    <div class="tab-pane fade show active" id="my-topics" role="tabpanel">
                        <div class="list-group">
                            @foreach($topics as $topic)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{$topic->name}}</strong>
                                    <small class="text-muted d-block">Criado em {{ \Carbon\Carbon::parse($topic->created_at)->format('d/m/Y') }}</small>
                                </div>
                                <a href="{{route('room.addTopic', [$room->id,$topic->id])}}" class="btn btn-sm btn-primary">Adicionar</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Aba Criar Novo Tópico -->
                    <div class="tab-pane fade" id="create-topic" role="tabpanel">
                        <form action="{{ route('room.createTopicRoom') }}" method="POST">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <div class="mb-3">
                                <label for="topicName" class="form-label">Nome do Tópico</label>
                                <input type="text" class="form-control" id="topicName" name="topic" placeholder="Digite o nome do tópico">
                            </div>
                            <button type="submit" class="btn btn-primary">Criar e Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Adicionar PDF -->
<div class="modal fade" id="addPdfModal" tabindex="-1" aria-labelledby="addPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPdfModalLabel"><i class="bi bi-file-earmark-pdf me-2"></i>Adicionar PDF à Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Navegação por Abas no Modal -->
                <ul class="nav nav-tabs" id="pdfTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="my-pdfs-tab" data-bs-toggle="tab" data-bs-target="#my-pdfs" type="button" role="tab">
                            Meus PDFs
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="upload-pdf-tab" data-bs-toggle="tab" data-bs-target="#upload-pdf" type="button" role="tab">
                            Enviar Novo PDF
                        </button>
                    </li>
                </ul>
                <!-- Conteúdo das Abas -->
                <div class="tab-content mt-3" id="pdfTabsContent">
                    <!-- Aba Meus PDFs -->
                    <div class="tab-pane fade show active" id="my-pdfs" role="tabpanel">
                        <div class="list-group">
                            @foreach($pdfs as $pdf)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{$pdf->name}}.pdf</strong>
                                    <small class="text-muted d-block">Enviado em {{ \Carbon\Carbon::parse($pdf->created_at)->format('d/m/Y') }}</small>
                                </div>
                                <a href="{{route('room.addPdf',[$room->id,$pdf->id])}}" class="btn btn-sm btn-primary">Adicionar</a>
                            </div>
                            @endforeach
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Exercicios_Geometria.pdf</strong>
                                    <small class="text-muted d-block">Enviado em 03/06/2025</small>
                                </div>
                                <button class="btn btn-sm btn-primary">Adicionar</button>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Probabilidade_Apostila.pdf</strong>
                                    <small class="text-muted d-block">Enviado em 01/06/2025</small>
                                </div>
                                <button class="btn btn-sm btn-primary">Adicionar</button>
                            </div>
                        </div>
                    </div>
                    <!-- Aba Enviar Novo PDF -->
                    <div class="tab-pane fade" id="upload-pdf" role="tabpanel">
                        <form action="{{ route('room.createPdfRoom') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                            <div class="mb-3">
                                <label class="form-label">Selecionar Arquivo PDF</label>
                                <input type="file" class="form-control" id="pdfFile" name="pdf_file" accept=".pdf">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Titulo pdf</label>
                                <textarea class="form-control" id="pdfDescription" name="pdf_title" placeholder="Digite o nome do pdf"></textarea>
                            </div>
                            <button type="submmit" class="btn btn-primary">Enviar e Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Listar Membros -->
<div class="modal fade" id="listMembersModal" tabindex="-1" aria-labelledby="listMembersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="listMembersModalLabel"><i class="bi bi-people me-2"></i>Membros da Sala</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @foreach($participants as $participant)
                    <div class="list-group-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <strong>{{ $participant->name }}</strong>
                                <small class="text-muted d-block">{{ $participant->email }}</small>
                                <span class="badge
                                    @if($participant->role == 1) bg-danger
                                    @elseif($participant->role == 2) bg-warning
                                    @else bg-secondary
                                    @endif">
                                    @if($participant->role == 1) Administrador
                                    @elseif($participant->role == 2) Gerente
                                    @else Convidado
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            {{-- @if($participant->userId != auth()->user()->id)
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#removeMemberModal{{ $participant->userId }}">
                            <i class="bi bi-person-x"></i> Remover
                            </button>
                            @endif --}}

                            <div class="dropdown">
                                @if(
                                $participant->userId == auth()->user()->id ||
                                $roleAuthUser == 1 ||
                                ($roleAuthUser == 2 && $participant->role == 3)
                                )
                                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if($participant->userId != auth()->user()->id)
                                    {{-- Admin pode mudar cargo de todos, exceto dele mesmo --}}
                                    @if($roleAuthUser == 1)
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changeRoleModal{{ $participant->userId }}">
                                            <i class="bi bi-person-gear me-2"></i>Mudar Cargo
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    @endif
                                    {{-- Gerente pode mudar cargo apenas de convidados (role 3) --}}
                                    @if($roleAuthUser == 2 && $participant->role == 3)
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changeRoleModal{{ $participant->userId }}">
                                            <i class="bi bi-person-gear me-2"></i>Mudar Cargo
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    @endif
                                    {{-- Admin pode remover todos, exceto dele mesmo --}}
                                    @if($roleAuthUser == 1)
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#removeMemberModal{{ $participant->userId }}">
                                            <i class="bi bi-person-x me-2"></i>Excluir
                                        </a>
                                    </li>
                                    @endif
                                    {{-- Gerente pode remover apenas convidados (role 3) --}}
                                    @if($roleAuthUser == 2 && $participant->role == 3)
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#removeMemberModal{{ $participant->userId }}">
                                            <i class="bi bi-person-x me-2"></i>Excluir
                                        </a>
                                    </li>
                                    @endif
                                    @endif
                                    {{-- Qualquer usuário pode sair da sala --}}
                                    @if($participant->userId == auth()->user()->id)
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#leaveRoomModal{{ $participant->userId }}">
                                            <i class="bi bi-box-arrow-right me-2"></i>Sair da Sala
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                                @endif
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@foreach($participants as $participant)
<!-- Modal: Mudar Cargo do Membro-->
<div class="modal fade" id="changeRoleModal{{ $participant->userId }}" tabindex="-1" aria-labelledby="changeRoleModalLabel{{ $participant->userId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeRoleModalLabel{{ $participant->userId }}"><i class="bi bi-person-gear me-2"></i>Mudar Cargo - {{ $participant->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('room.changeRole', [$room->id, $participant->userId]) }}" method="POST" id="changeRoleForm{{ $participant->userId }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Membro</label>
                        <input type="text" class="form-control" value="{{ $participant->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="newRole{{ $participant->userId }}" class="form-label">Novo Cargo</label>
                        <select class="form-select" name="role" required>
                            <option value="1" {{ $participant->role == 1 ? 'selected' : '' }}>Administrador</option>
                            <option value="2" {{ $participant->role == 2 ? 'selected' : '' }}>Gerente</option>
                            <option value="3" {{ $participant->role == 3 ? 'selected' : '' }}>Convidado</option>
                        </select>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Administrador:</strong> Controle total da sala<br>
                        <strong>Gerente:</strong> Pode gerenciar conteúdo e membros<br>
                        <strong>Convidado:</strong> Acesso básico à sala
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="changeRoleForm{{ $participant->userId }}" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Remover Membro-->
@if($participant->userId != auth()->user()->id)
<div class="modal fade" id="removeMemberModal{{ $participant->userId }}" tabindex="-1" aria-labelledby="removeMemberModalLabel{{ $participant->userId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeMemberModalLabel{{ $participant->userId }}"><i class="bi bi-person-x me-2"></i>Remover Membro - {{ $participant->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('room.removeMember', [$room->id,$participant->userId]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="user_id" value="{{ $participant->userId }}">
                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <div class="text-center">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Confirmar Remoção</h5>
                        <p>Tem certeza que deseja remover <strong>{{ $participant->name }}</strong> da sala?</p>
                        <p class="text-muted">Esta ação não pode ser desfeita.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Remover Membro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal: Sair da Sala -->
@if($participant->userId == auth()->user()->id)
<div class="modal fade" id="leaveRoomModal{{ $participant->userId }}" tabindex="-1" aria-labelledby="leaveRoomModalLabel{{ $participant->userId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leaveRoomModalLabel{{ $participant->userId }}">
                    <i class="bi bi-box-arrow-right text-warning me-2"></i>Sair da Sala
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('room.leaveRoom', [$room->id, $participant->userId]) }}" method="POST" id="leaveRoomForm{{ $participant->userId }}">
                    @csrf
                    @method('DELETE')

                    <div class="text-center">
                        <i class="bi bi-box-arrow-right text-warning" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Confirmar Saída</h5>
                        <p>Tem certeza que deseja sair da sala <strong>"{{ $room->name }}"</strong>?</p>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Atenção:</strong> Ao sair da sala você irá:
                            <ul class="mb-0 mt-2">
                                <li>Perder acesso a todos os conteúdos da sala</li>
                                <li>Não poderá mais participar do chat</li>
                                <li>Precisará de um novo convite para retornar</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="leaveRoomForm{{ $participant->userId }}" class="btn btn-warning">
                    <i class="bi bi-box-arrow-right me-1"></i>Sair da Sala
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach

<!-- Modal: Excluir Sala -->
<div class="modal fade" id="deleteRoomModal" tabindex="-1" aria-labelledby="deleteRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoomModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>Excluir Sala
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('room.destroy', $room->id) }}" method="POST" id="deleteRoomForm">
                    @csrf
                    @method('DELETE')

                    <div class="text-center">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Confirmar Exclusão</h5>
                        <p>Tem certeza que deseja excluir a sala <strong>"{{ $room->name }}"</strong>?</p>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Atenção:</strong> Esta ação é irreversível e irá:
                            <ul class="mb-0 mt-2">
                                <li>Remover todos os membros da sala</li>
                                <li>Excluir todos os conteúdos compartilhados</li>
                                <li>Apagar permanentemente a sala</li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="deleteRoomForm" class="btn btn-danger" id="deleteRoomBtn">
                    <i class="bi bi-trash me-1"></i>Excluir Sala
                </button>
            </div>
        </div>
    </div>
</div>
