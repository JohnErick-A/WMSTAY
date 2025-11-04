document.addEventListener('DOMContentLoaded', function(){
  const btn = document.getElementById('btnToggle');
  const sidebar = document.getElementById('sidebar');
  const showAdd = document.getElementById('showAddRoom');
  const addForm = document.getElementById('addRoomForm');
  if (btn && sidebar) {
    btn.addEventListener('click', () => { sidebar.classList.toggle('open'); });
  }
  if (showAdd && addForm) {
    showAdd.addEventListener('click', (e) => { e.preventDefault(); addForm.classList.toggle('hidden'); });
  }
});