document.addEventListener('DOMContentLoaded', function() {

    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
                return false;
            }
        });
    });

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const numberInputs = document.querySelectorAll('input[type="number"]');
    numberInputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            if (this.value && this.value < 0) {
                this.value = 0;
            }
        });
    });

    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    const currentLocation = window.location.pathname;
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    
    navLinks.forEach(function(link) {
        if (link.getAttribute('href') === currentLocation) {
            link.classList.add('active');
        }
    });

    const tableSearch = document.getElementById('tableSearch');
    if (tableSearch) {
        tableSearch.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('table tbody tr');
            
            tableRows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    }

    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(function(input) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });

    window.formatRupiah = function(angka, prefix = 'Rp ') {
        const numberString = angka.toString().replace(/[^,\d]/g, '');
        const split = numberString.split(',');
        const sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            const separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix + rupiah;
    };

    window.parseRupiah = function(rupiah) {
        return parseInt(rupiah.replace(/[^0-9]/g, '')) || 0;
    };

    window.scrollToTop = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };

    window.printPage = function() {
        window.print();
    };

    window.showLoading = function(message = 'Loading...') {
        const overlay = document.createElement('div');
        overlay.id = 'loadingOverlay';
        overlay.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                        background: rgba(0,0,0,0.5); display: flex; align-items: center; 
                        justify-content: center; z-index: 9999;">
                <div style="background: white; padding: 20px; border-radius: 10px; text-align: center;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 mb-0">${message}</p>
                </div>
            </div>
        `;
        document.body.appendChild(overlay);
    };

    window.hideLoading = function() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.remove();
        }
    };

    window.showToast = function(message, type = 'success') {
        const toastContainer = document.getElementById('toastContainer') || createToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    };

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
        return container;
    }

    window.confirmAction = function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    };

    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            showToast('Berhasil disalin ke clipboard!', 'success');
        }).catch(function() {
            showToast('Gagal menyalin!', 'danger');
        });
    };

    console.log('Toko Ikan Hias - System Ready');
    console.log('Laravel Version: 12.x');
    console.log('Bootstrap Version: 5.3.x');
});

if (document.getElementById('formTransaksi')) {
    const itemContainer = document.getElementById('itemContainer');
    const addItemBtn = document.getElementById('addItem');
    const totalBayarDisplay = document.getElementById('totalBayar');
    const totalBayarInput = document.getElementById('totalBayarInput');

    if (addItemBtn) {
        addItemBtn.addEventListener('click', function() {
            const firstRow = itemContainer.querySelector('.item-row');
            const newRow = firstRow.cloneNode(true);
            
            newRow.querySelectorAll('input, select').forEach(input => {
                if (input.type === 'number') input.value = 1;
                else if (input.classList.contains('subtotal-display')) input.value = 'Rp 0';
                else if (input.tagName === 'SELECT') input.value = '';
            });
            
            itemContainer.appendChild(newRow);
            attachEventListeners(newRow);
        });
    }

    function attachEventListeners(row) {
        const removeBtn = row.querySelector('.remove-item');
        const ikanSelect = row.querySelector('.ikan-select');
        const jumlahInput = row.querySelector('.jumlah-input');

        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (itemContainer.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    calculateTotal();
                } else {
                    alert('Minimal harus ada 1 item!');
                }
            });
        }

        if (ikanSelect) {
            ikanSelect.addEventListener('change', function() {
                updateSubtotal(row);
            });
        }

        if (jumlahInput) {
            jumlahInput.addEventListener('input', function() {
                const ikanSelect = row.querySelector('.ikan-select');
                const selectedOption = ikanSelect.options[ikanSelect.selectedIndex];
                const stok = parseInt(selectedOption.dataset.stok || 0);
                
                if (parseInt(this.value) > stok) {
                    alert(`Stok tidak mencukupi! Stok tersedia: ${stok}`);
                    this.value = stok;
                }
                updateSubtotal(row);
            });
        }
    }

    function updateSubtotal(row) {
        const ikanSelect = row.querySelector('.ikan-select');
        const jumlahInput = row.querySelector('.jumlah-input');
        const subtotalDisplay = row.querySelector('.subtotal-display');
        
        const selectedOption = ikanSelect.options[ikanSelect.selectedIndex];
        const harga = parseFloat(selectedOption.dataset.harga || 0);
        const jumlah = parseInt(jumlahInput.value || 0);
        const subtotal = harga * jumlah;
        
        subtotalDisplay.value = 'Rp ' + subtotal.toLocaleString('id-ID');
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const ikanSelect = row.querySelector('.ikan-select');
            const jumlahInput = row.querySelector('.jumlah-input');
            const selectedOption = ikanSelect.options[ikanSelect.selectedIndex];
            const harga = parseFloat(selectedOption.dataset.harga || 0);
            const jumlah = parseInt(jumlahInput.value || 0);
            total += harga * jumlah;
        });
        
        if (totalBayarDisplay) {
            totalBayarDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
        if (totalBayarInput) {
            totalBayarInput.value = total;
        }
    }

    document.querySelectorAll('.item-row').forEach(row => {
        attachEventListeners(row);
    });
}