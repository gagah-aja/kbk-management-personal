// Mobile Sidebar Toggle
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.querySelector('.mobile-overlay');
  sidebar.classList.toggle('show');
  overlay.classList.toggle('show');
}

// Auto close sidebar on mobile when clicking nav link
if (window.innerWidth <= 768) {
  document.querySelectorAll('#sidebar .nav-link').forEach(link => {
      link.addEventListener('click', () => {
          toggleSidebar();
      });
  });
}

// Logout Confirmation with SweetAlert
document.getElementById('logoutButton').addEventListener('click', function(e) {
  e.preventDefault();
  
  Swal.fire({
      title: 'Yakin ingin keluar?',
      text: 'Kamu akan keluar dari sistem.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#667eea',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, keluar',
      cancelButtonText: 'Batal'
  }).then((result) => {
      if (result.isConfirmed) {
          document.getElementById('logoutForm').submit();
      }
  });
});