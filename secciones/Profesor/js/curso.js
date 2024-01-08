//modales sencillos 

//modale curso
const modal_curso1 = document.querySelector('.modal_curso'); 
const styles_curso = document.querySelector('.modalC');
const closeModal_curso = document.querySelector('.modal_close_curso');

modal_curso1.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_curso.classList.add('modal--show2')
   styles_estudiantes.classList.remove('modal--show2')
   styles_calificaciones.classList.remove('modal--show2')
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
  styles_calificaciones.classList.remove('modal--show2')
   styles_avisos.classList.remove('modal--show2')
});

closeModal_estudiantes.addEventListener('click', (e)=>{
    e.preventDefault(); 
   styles_estudiantes.classList.remove('modal--show2')
});



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

//modal calificaciones
const modal_calificaciones1 = document.querySelector('.modal_calificaciones'); 
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
});