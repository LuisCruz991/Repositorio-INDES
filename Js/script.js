const btnSidebar = document.getElementById('btn-sidebar');
const sidebar = document.querySelector('.sidebar');

btnSidebar.addEventListener('click', () => {
  if (sidebar.classList.contains('hidden')) {
    sidebar.classList.remove('hidden');
    btnSidebar.classList.add('hidden')
  } else {
    sidebar.classList.add('hidden');
  }
});

const btnCloseSidebar = document.getElementById('boton');

btnCloseSidebar.addEventListener('click', () => {
  if (sidebar.classList.contains('hidden') == false) {
    sidebar.classList.add('hidden');
    btnSidebar.classList.remove('hidden')
  } else {
    sidebar.classList.add('hidden');
  }
});
  


  

