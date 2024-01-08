
//modales de editar y eliminar en la base de datos 

const openModal = document.querySelector('.b_login'); 
const abrirModal = document.querySelector('.b_editar'); 

const modal = document.querySelector('.modo');
const ventana = document.querySelector('.ventana');

const closeModal = document.querySelector('.modal_close');
const closeModal2 = document.querySelector('.modal_close2');
//const eliminar = document.querySelector('.eliminar');

openModal.addEventListener('click', (e)=>{
    e.preventDefault(); 
   modal.classList.add('modal--show')
});
/*openSecondModal.addEventListener('click', (e)=>{
    e.preventDefault(); 
   modal2.classList.add('modal--show')
});*/

closeModal.addEventListener('click', (e)=>{
    e.preventDefault(); 
   modal.classList.remove('modal--show')
});

/*closeModal2.addEventListener('click', (e)=>{
    e.preventDefault(); 
   modal2.classList.remove('modal--show')
});*/

/*eliminar.addEventListener('click', () =>{
    alert("¡Usuario eliminado");
}); */

abrirModal.addEventListener('click', (e)=>{
  e.preventDefault(); 
  ventana.classList.add('modal--show'); 
});

closeModal2.addEventListener('click', (e)=>{
    e.preventDefault(); 
   ventana.classList.remove('modal--show')
});

