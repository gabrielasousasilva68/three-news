const modoEscuro = document.getElementById('modoEscuro');

if (localStorage.getItem('modo') === 'escuro') {
  document.body.classList.add('escuro-modo');
  modoEscuro.textContent = '☀️';
} else {
  modoEscuro.textContent = '🌙';
}

modoEscuro.addEventListener('click', () => {
  document.body.classList.toggle('escuro-modo');

  if (document.body.classList.contains('escuro-modo')) {
    modoEscuro.textContent = '☀️';
    localStorage.setItem('modo', 'escuro');
  } else {
    modoEscuro.textContent = '🌙';
    localStorage.setItem('modo', 'claro');
  }
});
const comentarios = [];
const form = document.querySelector(`#form-comentario`);
const resultadoComentarios = document.querySelector(`#comentarios`);
form.addEventListener(`submit`, function(e){
  e.preventDefault();
  const nome = form.querySelector(`#nome`).value;
  const email = form.querySelector(`#email`).value;
  const mensagem = form.querySelector(`#mensagem`).value;
  const comentario = {nome, email, mensagem};
  comentarios.push(comentario);
  mostrarComentarios();
  form.reset();
});
function mostrarComentarios(){
    resultadoComentarios.innerHTML = ``;
    for(let i = 0; i < comentarios.length; i++){
        const comentario = comentarios[i];
        resultadoComentarios.innerHTML +=`
        <div class="comentario">
        <p><b>Nome: </b>${comentario.nome} </p>
        <p><b>Mensagem: </b>${comentario.mensagem} </p>
        </div> `
        ;
    }
}