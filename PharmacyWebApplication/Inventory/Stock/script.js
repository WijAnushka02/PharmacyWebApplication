document.addEventListener('DOMContentLoaded', () => {
    // Dummy data for demonstration purposes
    const medicines = [
        { id: 1, name: 'Aspirin', dosage: '325mg', quantity: 500, expiry: '2024-12-31', reorder: 100, supplier: 'PharmaCorp', status: 'all' },
        { id: 2, name: 'Ibuprofen', dosage: '200mg', quantity: 300, expiry: '2025-06-15', reorder: 50, supplier: 'MediSupplies', status: 'all' },
        { id: 3, name: 'Acetaminophen', dosage: '500mg', quantity: 400, expiry: '2024-11-20', reorder: 75, supplier: 'HealthMeds', status: 'all' },
        { id: 4, name: 'Amoxicillin', dosage: '250mg', quantity: 200, expiry: '2025-03-10', reorder: 40, supplier: 'PharmaCorp', status: 'all' },
        { id: 5, name: 'Ciprofloxacin', dosage: '500mg', quantity: 150, expiry: '2024-10-05', reorder: 30, supplier: 'MediSupplies', status: 'all' },
        { id: 6, name: 'Metformin', dosage: '500mg', quantity: 600, expiry: '2025-01-22', reorder: 120, supplier: 'HealthMeds', status: 'all' },
        { id: 7, name: 'Lisinopril', dosage: '10mg', quantity: 450, expiry: '2024-09-18', reorder: 90, supplier: 'PharmaCorp', status: 'all' },
        { id: 8, name: 'Amlodipine', dosage: '5mg', quantity: 45, expiry: '2025-02-28', reorder: 50, supplier: 'HealthMeds', status: 'low-stock' },
        { id: 9, name: 'Atorvastatin', dosage: '20mg', quantity: 12, expiry: '2024-08-30', reorder: 20, supplier: 'PharmaCorp', status: 'low-stock' },
        { id: 10, name: 'Levothyroxine', dosage: '100mcg', quantity: 0, expiry: '2025-05-01', reorder: 30, supplier: 'MediSupplies', status: 'out-of-stock' },
        { id: 11, name: 'Omeprazole', dosage: '20mg', quantity: 50, expiry: '2024-06-01', reorder: 25, supplier: 'HealthMeds', status: 'expired' },
    ];

    const inventoryTableBody = document.getElementById('inventoryTableBody');
    const medicineSearch = document.getElementById('medicineSearch');
    const tabLinks = document.querySelectorAll('.tab');
    const modal = document.getElementById('medicineModal');
    const addNewMedicineBtn = document.getElementById('addNewMedicineBtn');
    const closeModalBtn = document.querySelector('.close-button');
    const medicineForm = document.getElementById('medicineForm');
    const modalTitle = document.getElementById('modalTitle');
    const medicineIdInput = document.getElementById('medicineId');

    let currentData = medicines;
    let currentTab = 'all';

    const renderTable = (data) => {
        inventoryTableBody.innerHTML = '';
        if (data.length === 0) {
            inventoryTableBody.innerHTML = `<tr><td colspan="7" class="text-center">No medicines found.</td></tr>`;
            return;
        }
        data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>${item.dosage}</td>
                <td>${item.quantity}</td>
                <td>${item.expiry}</td>
                <td>${item.reorder}</td>
                <td>${item.supplier}</td>
                <td class="action-buttons">
                    <button class="action-button edit" data-id="${item.id}"><span class="material-symbols-outlined">edit</span></button>
                    <button class="action-button delete" data-id="${item.id}"><span class="material-symbols-outlined">delete</span></button>
                </td>
            `;
            inventoryTableBody.appendChild(row);
        });

        // Add event listeners for edit and delete buttons
        document.querySelectorAll('.action-button.edit').forEach(button => {
            button.addEventListener('click', (e) => openModal(e.currentTarget.dataset.id));
        });

        document.querySelectorAll('.action-button.delete').forEach(button => {
            button.addEventListener('click', (e) => deleteMedicine(e.currentTarget.dataset.id));
        });
    };

    const filterAndRender = () => {
        const searchTerm = medicineSearch.value.toLowerCase();
        let filteredData = medicines.filter(item => {
            return item.status === currentTab || currentTab === 'all';
        });

        if (searchTerm) {
            filteredData = filteredData.filter(item => 
                item.name.toLowerCase().includes(searchTerm) ||
                item.supplier.toLowerCase().includes(searchTerm)
            );
        }

        renderTable(filteredData);
    };

    const updateTabCounts = () => {
        tabLinks.forEach(tab => {
            const status = tab.dataset.tab;
            const count = medicines.filter(item => item.status === status || status === 'all').length;
            tab.querySelector('.tab-count').textContent = count;
        });
    };

    const openModal = (id = null) => {
        modal.style.display = 'block';
        medicineForm.reset();
        if (id) {
            modalTitle.textContent = 'Edit Medicine';
            const medicine = medicines.find(m => m.id == id);
            if (medicine) {
                medicineIdInput.value = medicine.id;
                document.getElementById('medicineName').value = medicine.name;
                document.getElementById('dosage').value = medicine.dosage;
                document.getElementById('quantity').value = medicine.quantity;
                document.getElementById('expiryDate').value = medicine.expiry;
                document.getElementById('reorderThreshold').value = medicine.reorder;
                document.getElementById('supplier').value = medicine.supplier;
            }
        } else {
            modalTitle.textContent = 'Add New Medicine';
            medicineIdInput.value = '';
        }
    };

    const closeModal = () => {
        modal.style.display = 'none';
    };

    const deleteMedicine = (id) => {
        if (confirm('Are you sure you want to delete this medicine?')) {
            const index = medicines.findIndex(m => m.id == id);
            if (index !== -1) {
                medicines.splice(index, 1);
                filterAndRender();
                updateTabCounts();
            }
        }
    };

    // Event Listeners
    tabLinks.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            tabLinks.forEach(t => t.classList.remove('active'));
            e.currentTarget.classList.add('active');
            currentTab = e.currentTarget.dataset.tab;
            filterAndRender();
        });
    });

    medicineSearch.addEventListener('input', filterAndRender);
    addNewMedicineBtn.addEventListener('click', () => openModal());
    closeModalBtn.addEventListener('click', closeModal);
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    medicineForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const id = medicineIdInput.value;
        const medicineData = {
            name: document.getElementById('medicineName').value,
            dosage: document.getElementById('dosage').value,
            quantity: parseInt(document.getElementById('quantity').value),
            expiry: document.getElementById('expiryDate').value,
            reorder: parseInt(document.getElementById('reorderThreshold').value),
            supplier: document.getElementById('supplier').value,
        };

        if (id) {
            const index = medicines.findIndex(m => m.id == id);
            if (index !== -1) {
                medicines[index] = { ...medicines[index], ...medicineData };
            }
        } else {
            const newId = Math.max(...medicines.map(m => m.id)) + 1;
            medicines.push({ id: newId, ...medicineData, status: 'all' });
        }
        closeModal();
        filterAndRender();
        updateTabCounts();
    });

    // Initial render
    filterAndRender();
    updateTabCounts();
});