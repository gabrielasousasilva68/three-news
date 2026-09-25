document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. GERENCIAMENTO DE TEMA (SWITCH TOGGLE)
    // ==========================================
    const toggleTema = document.getElementById('btn-toggle-tema');
    const temaSalvo = localStorage.getItem('tema');

    if (temaSalvo === 'claro') {
        document.body.classList.add('modo-claro');
        if (toggleTema) toggleTema.checked = true;
    }

    setTimeout(() => {
        document.body.classList.remove('preload');
    }, 100);

    if (toggleTema) {
        toggleTema.addEventListener('change', () => {
            if (toggleTema.checked) {
                document.body.classList.add('modo-claro');
                localStorage.setItem('tema', 'claro');
            } else {
                document.body.classList.remove('modo-claro');
                localStorage.setItem('tema', 'escuro');
            }
        });
    }

    // ==========================================
    // 2. SISTEMA DE NOTIFICAÇÕES (TOAST / INLINE)
    // ==========================================
    window.exibirToast = function(mensagem, tipo = 'sucesso') {
        let toast = document.getElementById('toast-notificacao');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'toast-notificacao';
            toast.style.cssText = `
                position: fixed;
                bottom: 25px;
                right: 25px;
                padding: 12px 24px;
                border-radius: 8px;
                color: #ffffff;
                font-weight: 600;
                box-shadow: 0 8px 20px rgba(0,0,0,0.4);
                z-index: 10000;
                transition: opacity 0.3s ease, transform 0.3s ease;
                opacity: 0;
                transform: translateY(20px);
            `;
            document.body.appendChild(toast);
        }

        toast.style.background = tipo === 'erro' 
            ? 'linear-gradient(135deg, #d32f2f, #9a0007)' 
            : 'linear-gradient(135deg, #d90429, #ef233c)';
        toast.innerText = mensagem;
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
        }, 3000);
    };

    function exibirNotificacao(mensagem, elementoContainer) {
        if (!elementoContainer) return;
        
        const alertaExistente = elementoContainer.querySelector('.mensagem-erro-inline');
        if (alertaExistente) {
            alertaExistente.remove();
        }

        const divErro = document.createElement('div');
        divErro.className = 'mensagem-erro mensagem-erro-inline';
        divErro.textContent = mensagem;

        elementoContainer.prepend(divErro);
        divErro.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // ==========================================
    // 3. TROCA DE ABAS NA SIDEBAR
    // ==========================================
    const sidebarLinks = document.querySelectorAll('.sidebar-link[data-aba]');
    const secoesAba = document.querySelectorAll('.aba-conteudo');
    const perfisSessao = document.querySelectorAll('.perfil-sessao');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const abaAlvo = link.getAttribute('data-aba');

            sidebarLinks.forEach(l => l.classList.remove('ativo'));
            secoesAba.forEach(secao => secao.classList.remove('ativo'));
            perfisSessao.forEach(sessao => sessao.classList.remove('ativo'));

            link.classList.add('ativo');
            
            const elementoAlvo = document.getElementById(abaAlvo);
            if (elementoAlvo) {
                elementoAlvo.classList.add('ativo');

                const perfilContainer = elementoAlvo.closest('.perfil-sessao') || elementoAlvo.querySelector('.perfil-sessao');
                if (perfilContainer) {
                    perfilContainer.classList.add('ativo');
                }
            }
        });
    });

    // ==========================================
    // 4. MODAL DE EXCLUSÃO DE CONTA
    // ==========================================
    const modal = document.getElementById('modalExcluirConta');
    const btnAbrirModal = document.getElementById('btnAbrirModalExcluir');
    const btnCancelarModal = document.getElementById('btnCancelarExclusao');

    if (modal && btnAbrirModal && btnCancelarModal) {
        btnAbrirModal.addEventListener('click', () => {
            modal.showModal();
        });

        btnCancelarModal.addEventListener('click', () => {
            modal.close();
        });
    }

    // ==========================================
    // 5. VALIDAÇÃO DE FORMULÁRIO (CADASTRO DE NOTÍCIA)
    // ==========================================
    const formulario = document.getElementById('formNoticia');

    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();

            const titulo = formulario.querySelector('#titulo');
            const resumo = formulario.querySelector('#resumo');
            const conteudo = formulario.querySelector('#conteudo');
            const categoria = formulario.querySelector('#categoria');

            const tituloNoticia = titulo ? titulo.value.trim() : '';
            const resumoNoticia = resumo ? resumo.value.trim() : '';
            const conteudoNoticia = conteudo ? conteudo.value.trim() : '';
            const categoriaNoticia = categoria ? categoria.value : '';

            if (
                tituloNoticia === '' ||
                resumoNoticia === '' ||
                conteudoNoticia === '' ||
                categoriaNoticia === ''
            ) {
                exibirNotificacao('Preencha todos os campos obrigatórios.', formulario);
                return;
            }

            if (tituloNoticia.length < 5) { 
                exibirNotificacao('Escreva um título válido para a notícia.', formulario); 
                return; 
            }
            if (resumoNoticia.length < 15) { 
                exibirNotificacao('O resumo precisa ter no mínimo 15 caracteres.', formulario); 
                return; 
            }
            if (conteudoNoticia.length < 50) { 
                exibirNotificacao('O conteúdo da notícia precisa ter no mínimo 50 caracteres.', formulario); 
                return; 
            }

            formulario.submit();
        });
    }

    // ==========================================
    // 6. VALIDAÇÃO DE COMENTÁRIO
    // ==========================================
    const formComentario = document.getElementById("formComentario");
    const campoComentario = document.getElementById("comentario");

    if (formComentario && campoComentario) {
        formComentario.addEventListener("submit", function(e) {
            const comentario = campoComentario.value.trim();
            if (comentario.length === 0) {
                e.preventDefault();
                window.exibirToast("Digite um comentário antes de enviar.", "erro");
                return;
            }
        });
    }

    // ==========================================
    // 7. SCRIPT DE TRANSIÇÃO ENTRE AS TELAS (LOGIN e RECUPERAR SENHA)
    // ==========================================
    const blocoLogin = document.getElementById('bloco-login');
    const blocoRecuperar = document.getElementById('bloco-recuperar');
    const linkEsqueci = document.getElementById('link-esqueci-senha');
    const linkVoltar = document.getElementById('link-voltar-login');

    if (linkEsqueci && linkVoltar && blocoLogin && blocoRecuperar) {
        linkEsqueci.addEventListener('click', function(e) {
            e.preventDefault();
            blocoLogin.style.display = 'none';
            blocoRecuperar.style.display = 'block';
        });

        linkVoltar.addEventListener('click', function(e) {
            e.preventDefault();
            blocoRecuperar.style.display = 'none';
            blocoLogin.style.display = 'block';
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('erro') === 'email_nao_encontrado' && blocoLogin && blocoRecuperar) {
        blocoLogin.style.display = 'none';
        blocoRecuperar.style.display = 'block';
    }

});

// ==========================================
// 8. FUNÇÕES DE NOTÍCIAS SALVAS (ESCOPO GLOBAL WINDOW)
// ==========================================
window.toggleNoticiasSalvas = function() {
    const gaveta = document.getElementById('gaveta-salvas');
    const overlay = document.getElementById('overlay-gaveta');
    if (gaveta) {
        gaveta.classList.toggle('aberto');
        if (overlay) overlay.classList.toggle('aberto');
        if (gaveta.classList.contains('aberto')) {
            window.carregarNoticiasSalvas();
        }
    }
};

window.carregarNoticiasSalvas = function() {
    fetch('../php/noticias_salvas_acoes.php', { method: 'POST' })
        .then(res => res.json())
        .then(data => window.renderizarNoticiasSalvas(data))
        .catch(err => console.error('Erro ao carregar notícias salvas:', err));
};

window.renderizarNoticiasSalvas = function(dados) {
    const conteudo = document.getElementById('salvas-conteudo');
    const badge = document.getElementById('badge-salvas');

    if (badge) {
        badge.innerText = dados.total_itens || 0;
    }

    if (!conteudo) return;

    if (!dados.itens || dados.itens.length === 0) {
        conteudo.innerHTML = '<p class="texto-secundario texto-central">Você não possui notícias salvas para ler depois.</p>';
        return;
    }

    let html = '<ul class="lista-noticias-salvas">';
    dados.itens.forEach(item => {
        html += `
            <li class="item-noticia-salva">
                <div class="item-info">
                    <a href="noticia.php?id=${item.id_noticia}" class="item-titulo">${item.titulo}</a>
                    <span class="item-categoria">${item.categoria}</span>
                </div>
                <div class="item-controles">
                    <button class="btn-remover-item" type="button" title="Remover dos salvos" onclick="window.removerNoticiaSalva(${item.id_noticia})">&times;</button>
                </div>
            </li>
        `;
    });
    html += '</ul>';

    conteudo.innerHTML = html;
};

window.salvarNoticia = function(idNoticia) {
    const formData = new FormData();
    formData.append('acao', 'salvar');
    formData.append('id_noticia', idNoticia);

    fetch('../php/noticias_salvas_acoes.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(dados => {
        if (dados.sucesso) {
            window.exibirToast('Notícia salva para ler mais tarde!', 'sucesso');
            window.renderizarNoticiasSalvas(dados);
            
            const gaveta = document.getElementById('gaveta-salvas');
            const overlay = document.getElementById('overlay-gaveta');
            if (gaveta && !gaveta.classList.contains('aberto')) {
                gaveta.classList.add('aberto');
                if (overlay) overlay.classList.add('aberto');
            }
        } else {
            window.exibirToast(dados.mensagem || 'Erro ao salvar notícia.', 'erro');
        }
    })
    .catch(err => {
        console.error('Erro ao salvar notícia:', err);
        window.exibirToast('Erro de comunicação com o servidor.', 'erro');
    });
};

window.removerNoticiaSalva = function(idNoticia) {
    const formData = new FormData();
    formData.append('acao', 'remover');
    formData.append('id_noticia', idNoticia);

    fetch('../php/noticias_salvas_acoes.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(dados => {
        if (dados.sucesso) {
            window.exibirToast('Notícia removida dos salvos.', 'sucesso');
            window.renderizarNoticiasSalvas(dados);
        } else {
            window.exibirToast(dados.mensagem || 'Erro ao remover notícia.', 'erro');
        }
    })
    .catch(err => console.error('Erro ao remover notícia salva:', err));
};