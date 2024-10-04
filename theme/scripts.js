

    // كود Chart.js للرسوم البيانية
    const ctxVisitors = document.getElementById('visitorsChart');
    console.log('ctxVisitors:', ctxVisitors); // التأكد من أن العنصر موجود
    if (ctxVisitors) {
        const visitorsChart = new Chart(ctxVisitors.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['فيس بوك', 'إنستغرام', 'سناب شات', 'تيك توك'],
                datasets: [{
                    data: [40, 30, 20, 10],
                    backgroundColor: ['#3b5998', 'rgb(227, 84, 84)', '#ffcc00', '#000000'],
                }]
            },
        });
    }

    const ctxAgeDistribution = document.getElementById('ageDistributionChart');
    console.log('ctxAgeDistribution:', ctxAgeDistribution); // التأكد من أن العنصر موجود
    if (ctxAgeDistribution) {
        const ageDistributionChart = new Chart(ctxAgeDistribution.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['20-23 سنة', '18-20 سنة', '35-60 سنة', '26-35 سنة'],
                datasets: [{
                    data: [40, 30, 20, 10],
                    backgroundColor: ['#ec6b84', 'black', '#fefa66', '#6078d0'],
                    borderColor: ['rgba(225, 48, 108, 1)', 'black', 'rgba(255, 204, 0, 1)', 'rgba(88, 81, 219, 1)'],
                }]
            }
        });
    }

    const ctxAdCampaign = document.getElementById('adCampaignChart');
    console.log('ctxAdCampaign:', ctxAdCampaign); // التأكد من أن العنصر موجود
    if (ctxAdCampaign) {
        const adCampaignChart = new Chart(ctxAdCampaign.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                datasets: [
                    {
                        label: 'الزوار',
                        data: [200, 100, 300, 200, 100, 100, 250],
                        backgroundColor: '#e75672',
                        borderColor: 'rgba(193, 53, 132, 1)',
                        borderWidth: 1,
                        borderRadius: 10,
                        barThickness: 20
                    },
                    {
                        label: 'المبيعات',
                        data: [400, 300, 200, 500, 300, 400, 300],
                        backgroundColor: 'black',
                        borderColor: 'black',
                        borderWidth: 1,
                        borderRadius: 10,
                        barThickness: 20
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true
                        },
                        ticks: {
                            stepSize: 100,
                            callback: function(value) {
                                if (value % 100 === 0 && value <= 500) {
                                    return value;
                                }
                                return '';
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    }

    const ctxSalesProfit = document.getElementById('salesProfitChart');
    console.log('ctxSalesProfit:', ctxSalesProfit); // التأكد من أن العنصر موجود
    if (ctxSalesProfit) {
        const salesProfitChart = new Chart(ctxSalesProfit.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['5k', '10k', '15k', '20k', '25k', '30k', '35k', '40k', '45k', '50k', '55k', '60k'],
                datasets: [
                    {
                        label: 'المبيعات',
                        data: [40, 60, 80, 40, 70, 50, 100, 70, 50, 90, 80, 40],
                        backgroundColor: 'rgba(225, 48, 108, 0.6)',
                        borderColor: 'rgba(225, 48, 108, 1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'الأرباح',
                        data: [30, 50, 70, 50, 60, 90, 90, 60, 70, 80, 70, 90],
                        backgroundColor: 'black',
                        borderColor: 'black',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        align: 'end'
                    }
                }
            }
        });
    }
  
    // كود إدارة العملاء
    const rowsPerPage = 6;
    let currentPage = 1;
    let clientToDelete = null;

    const clients = [
        { id: '01', logo: '../pic/clintepic.png', name: 'الاسم', email: 'البريد الالكتروني', date: '2023-07-01', campaigns: '3' },
        { id: '02', logo: '../pic/clintepic.png', name: 'الاسم', email: 'البريد الالكتروني', date: '2023-07-02', campaigns: '2' },
        { id: '03', logo: '../pic/clintepic.png', name: 'الاسم', email: 'البريد الالكتروني', date: '2023-07-03', campaigns: '4' },
        { id: '04', logo: '../pic/clintepic.png', name: 'الاسم', email: 'البريد الالكتروني', date: '2023-07-04', campaigns: '1' },
        { id: '05', logo: '../pic/clintepic.png', name: 'الاسم', email: 'البريد الالكتروني', date: '2023-07-05', campaigns: '5' },
        { id: '06', logo: '../pic/clintepic.png', name: 'الاسم', email: 'البريد الالكتروني', date: '2023-07-06', campaigns: '3' },
    ];

    function displayRows() {
        const tableBody = document.getElementById("clients-table-body");
        tableBody.innerHTML = '';

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const rowsToDisplay = clients.slice(start, end);

        rowsToDisplay.forEach(client => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td data-label="المعرف">${client.id}</td>
                <td data-label="شعار العميل"><img class="clintepicture" src="${client.logo}" alt="Logo"></td>
                <td data-label="الاسم">${client.name}</td>
                <td data-label="البريد الإلكتروني">${client.email}</td>
                <td data-label="تاريخ الانضمام">${client.date}</td>
                <td data-label="الحملات">${client.campaigns}</td>
                <td data-label="إعدادات">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle custom-dropdown-toggle" type="button" id="dropdownMenuButton${client.id}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton${client.id}">
                            <li><a class="dropdown-item" href="#" onclick="confirmDeleteClient('${client.id}')"><i class="fas fa-trash-alt me-2 text-danger"></i>حذف</a></li>
                            <li><a class="dropdown-item" href="#" onclick="cancelClient('${client.id}')"><i class="fas fa-ban me-2 text-warning"></i>إغلاق</a></li>
                            <li><a class="dropdown-item" href="#" onclick="editClient('${client.id}')"><i class="fas fa-edit me-2"></i>تعديل</a></li>
                        </ul>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        document.getElementById("page-info").textContent = `الصفحة ${currentPage} من ${Math.ceil(clients.length / rowsPerPage)}`;
        document.getElementById("prev-button").disabled = currentPage === 1;
        document.getElementById("next-button").disabled = currentPage === Math.ceil(clients.length / rowsPerPage);
    }

    function nextPage() {
        if ((currentPage * rowsPerPage) < clients.length) {
            currentPage++;
            displayRows();
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            displayRows();
        }
    }

    function confirmDeleteClient(clientId) {
        clientToDelete = clientId;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        deleteModal.show();
    }

    document.getElementById('confirmDeleteButton').addEventListener('click', function () {
        if (clientToDelete) {
            deleteClient(clientToDelete);
        }
        const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
        deleteModal.hide();
    });

    function deleteClient(clientId) {
        const clientIndex = clients.findIndex(client => client.id === clientId);
        if (clientIndex !== -1) {
            clients.splice(clientIndex, 1);
            displayRows();
        }
    }

    // استدعاء عرض الصفوف عند تحميل الصفحة
    displayRows();
