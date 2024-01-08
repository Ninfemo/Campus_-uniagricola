//modales sencillos 

//modale curso
const modal_curso1 = document.querySelector('.modal_curso'); 
const styles_curso = document.querySelector('.modalC');
const closeModal_curso = document.querySelector('.modal_close_curso');

modal_curso1.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_curso.classList.add('modal--show2')
   styles_estudiantes.classList.remove('modal--show2')
   //styles_calificaciones.classList.remove('modal--show2')
   styles_avisos.classList.remove('modal--show2')
});

closeModal_curso.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_curso.classList.remove('modal--show2')
});

//modal estudiantes
const modal_estudiantes1 = document.querySelector('.modal_estudiantes'); 
const styles_estudiantes = document.querySelector('.modalE');
const closeModal_estudiantes = document.querySelector('.modal_close_estudiantes');

modal_estudiantes1.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_estudiantes.classList.add('modal--show2')
   styles_curso.classList.remove('modal--show2')
  // styles_calificaciones.classList.remove('modal--show2')
   styles_avisos.classList.remove('modal--show2')
});

closeModal_estudiantes.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_estudiantes.classList.remove('modal--show2')
});

//modal calificaciones
/*const modal_calificaciones1 = document.querySelector('.modal_calificaciones'); 
const styles_calificaciones = document.querySelector('.modalF');
const closeModal_calificaciones = document.querySelector('.modal_close_calificaciones');

modal_calificaciones1.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_calificaciones.classList.add('modal--show2')
   styles_curso.classList.remove('modal--show2')
   styles_estudiantes.classList.remove('modal--show2')
   styles_avisos.classList.remove('modal--show2')
});

closeModal_calificaciones.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_calificaciones.classList.remove('modal--show2')
});*/

//modal avisos
const modal_avisos1 = document.querySelector('.modal_avisos'); 
const styles_avisos = document.querySelector('.modalA');
const closeModal_avisos = document.querySelector('.modal_close_avisos');

modal_avisos1.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_avisos.classList.add('modal--show2')
   styles_curso.classList.remove('modal--show2')
   styles_estudiantes.classList.remove('modal--show2')
   styles_calificaciones.classList.remove('modal--show2')
});

closeModal_avisos.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_avisos.classList.remove('modal--show2')
});

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

