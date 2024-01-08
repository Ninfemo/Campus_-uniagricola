const openModal = document.querySelector('.b_registrar'); 
const openModal2 = document.querySelector('.b_ingresar'); 

const modal = document.querySelector('.modo_container');
const modal2 = document.querySelector('.modo_container2');

const closeModal = document.querySelector('.modal_close');
const closeModal2 = document.querySelector('.modal_close2');


openModal.addEventListener('click', (e)=>{
    e.preventDefault(); 
    modal.classList.add('modal--show')
});
openModal2.addEventListener('click', (e)=>{
    e.preventDefault(); 
    modal2.classList.add('modal--show')
});


closeModal.addEventListener('click', (e)=>{
    e.preventDefault(); 
    modal.classList.remove('modal--show')
});
closeModal2.addEventListener('click', (e)=>{
    e.preventDefault(); 
    modal2.classList.remove('modal--show')
});


