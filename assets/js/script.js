/**
 * Delicia by Dilla - Main JavaScript File
 * Author: Sardilla
 * Description: JavaScript untuk interaktivitas dan fungsionalitas dasar
 */

// Fungsi untuk konfirmasi hapus
function confirmDelete(itemType, itemName) {
    return confirm(`Apakah Anda yakin ingin menghapus ${itemType} "${itemName}"?`);
}

// Fungsi untuk validasi form
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;

    inputs.forEach(function(input) {
        if (input.value.trim() === '') {
            input.style.borderColor = '#ff4444';
            isValid = false;
        } else {
            input.style.borderColor = '#ccc';
        }
    });

    if (!isValid) {
        alert('Mohon lengkapi semua field yang wajib diisi!');
    }

    return isValid;
}

// Fungsi untuk format rupiah
function formatRupiah(angka, prefix = 'Rp ') {
    const number_string = angka.replace(/[^,\d]/g, '').toString();
    const split = number_string.split(',');
    const sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        const separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix === undefined ? rupiah : (rupiah ? prefix + rupiah : '');
}

// Fungsi untuk input harga dengan format rupiah
function formatHargaInput(input) {
    input.addEventListener('keyup', function(e) {
        input.value = formatRupiah(this.value, '');
    });
}

// Fungsi untuk preview gambar sebelum upload
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Fungsi untuk toggle sidebar mobile
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('active');
    }
}

// Fungsi untuk smooth scrolling
function smoothScroll(target) {
    document.querySelector(target).scrollIntoView({
        behavior: 'smooth'
    });
}

// Fungsi untuk notifikasi toast
function showToast(message, type = 'info') {
    // Buat elemen toast
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = message;
    
    // Style toast
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 8px;
        color: white;
        font-weight: bold;
        z-index: 9999;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    `;

    // Set warna berdasarkan type
    switch (type) {
        case 'success':
            toast.style.backgroundColor = '#4caf50';
            break;
        case 'error':
            toast.style.backgroundColor = '#f44336';
            break;
        case 'warning':
            toast.style.backgroundColor = '#ff9800';
            break;
        default:
            toast.style.backgroundColor = '#2196f3';
    }

    // Tambahkan ke body
    document.body.appendChild(toast);

    // Animasi masuk
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(0)';
    }, 100);

    // Hapus setelah 3 detik
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Fungsi untuk konfirmasi checkout
function confirmCheckout() {
    return confirm('Apakah Anda yakin ingin melanjutkan checkout? Pastikan semua data sudah benar.');
}

// Fungsi untuk update quantity di keranjang
function updateQuantity(productId, quantity) {
    if (quantity < 1) {
        if (confirm('Hapus item ini dari keranjang?')) {
            // Logic untuk hapus item
            window.location.href = `hapus_keranjang.php?id=${productId}`;
        }
        return;
    }
    
    // Logic untuk update quantity
    // Implementasi AJAX bisa ditambahkan di sini
    fetch(`update_keranjang.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Reload untuk update tampilan
        } else {
            alert('Gagal update quantity!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan!');
    });
}

// Event listeners untuk DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    // Format input harga otomatis
    const hargaInputs = document.querySelectorAll('input[name="harga"], input[name="price"]');
    hargaInputs.forEach(input => {
        formatHargaInput(input);
    });

    // Preview gambar untuk input file
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        const previewId = input.getAttribute('data-preview');
        if (previewId) {
            input.addEventListener('change', function() {
                previewImage(this, previewId);
            });
        }
    });

    // Konfirmasi delete untuk semua tombol hapus
    const deleteButtons = document.querySelectorAll('.btn-delete, .delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const itemType = this.getAttribute('data-type') || 'item';
            const itemName = this.getAttribute('data-name') || 'ini';
            if (!confirmDelete(itemType, itemName)) {
                e.preventDefault();
            }
        });
    });

    // Mobile sidebar toggle
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Export fungsi untuk digunakan di file lain
window.DeliciaJS = {
    confirmDelete,
    validateForm,
    formatRupiah,
    showToast,
    confirmCheckout,
    updateQuantity,
    previewImage,
    toggleSidebar
};
