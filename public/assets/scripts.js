

document.addEventListener('DOMContentLoaded', function () {
  const body = document.querySelector("body"),
      sidebar = document.querySelector(".sidebar"),
      toggle = document.querySelector(".toggle"),
      profileDropdown = document.querySelector(".profile-dropdown .dropdown-toggle"),
      contentWrapper = document.querySelector(".content-wrapper");

  // Toggle the sidebar open/close state

//   toggle.addEventListener("click", () => {
//       sidebar.classList.toggle("close");
//       contentWrapper.classList.toggle("sidebar-closed");
//       if (sidebar.classList.contains("close")) {
//           document.querySelector(".navbar").style.marginRight = "78px";
//       } else {
//           document.querySelector(".navbar").style.marginRight = "250px";
//       }
//       document.querySelector(".navbar").style.width = `calc(100% - ${sidebar.classList.contains('close') ? 78 : 250}px)`;
//   });


  // Show/hide the dropdown menu on profile click
  profileDropdown&&profileDropdown.addEventListener("click", () => {
      profileDropdown.parentElement.classList.toggle("show");
  });

  // Ensure the sidebar is closed on smaller screens
  if (window.innerWidth <= 768) {
    sidebar&&sidebar.classList.add("close");
    contentWrapper&&contentWrapper.classList.add("sidebar-closed");
    if(document.querySelector(".navbar"))
    {
      document.querySelector(".navbar").style.marginRight = "0";
      document.querySelector(".navbar").style.width = `100%`;
    }
      if(sidebar)
        sidebar.style.position = 'fixed';
  } else {
    sidebar&&sidebar.classList.remove("close");
    contentWrapper&&contentWrapper.classList.remove("sidebar-closed");
    if(document.querySelector(".navbar")) {
      document.querySelector(".navbar").style.marginRight = "250px";
      document.querySelector(".navbar").style.width = `calc(100% - 250px)`;
    }
    if(sidebar)
      sidebar.style.position = 'fixed';
  }

  // Adjust layout on window resize
  window.addEventListener("resize", () => {
      if (window.innerWidth <= 768) {
        sidebar&&sidebar.classList.add("close");
        contentWrapper&&contentWrapper.classList.add("sidebar-closed");
        if(document.querySelector(".navbar")) {
          document.querySelector(".navbar").style.marginRight = "0";
          document.querySelector(".navbar").style.width = `100%`;
        }
        if(sidebar)
          sidebar.style.position = 'fixed';
      } else {
        sidebar&&sidebar.classList.remove("close");
        contentWrapper&&contentWrapper.classList.remove("sidebar-closed");
        if(document.querySelector(".navbar")) {
          document.querySelector(".navbar").style.marginRight = "250px";
          document.querySelector(".navbar").style.width = `calc(100% - 250px)`;
        }
        if(sidebar)
          sidebar.style.position = 'fixed';
      }
  });
  if(document.getElementById('adCampaignChart'))
  {
    const ct = document.getElementById('adCampaignChart').getContext('2d');
    const adCampaignChart = new Chart(ct, {
      type: 'bar',
      data: {
        labels: ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        datasets: [
          {
            label: 'CPC',
            data: [200, 100, 300, 200, 100, 100, 250],
            backgroundColor: 'rgba(0, 255, 255, 0.6)',
            borderColor: 'rgba(0, 255, 255, 1)',
            borderWidth: 1,
            borderRadius: 10,
            barThickness: 20
          },
          {
            label: 'CPL',
            data: [400, 300, 200, 500, 300, 400, 300],
            backgroundColor: 'rgba(0, 0, 255, 0.6)',
            borderColor: 'rgba(0, 0, 255, 1)',
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
              display: false  // إخفاء الخطوط العمودية
            },

          },
          y: {
            beginAtZero: true,
            grid: {
              display: true  // إظهار الخطوط الأفقية
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
  if(document.getElementById('customerStatsChart'))
  {
    const ctxCustomerStats = document.getElementById('customerStatsChart').getContext('2d');
    const customerStatsChart = new Chart(ctxCustomerStats, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [
          {
            label: 'عميل مكرر',
            data: [200, 300, 250, 200, 150, 100, 150, 200, 250, 300],
            borderColor: 'red',
            fill: false,
            tension: 0.4
          },
          {
            label: 'عميل جديد',
            data: [100, 200, 150, 200, 150, 100, 200, 250, 200, 250, 200, 150],
            borderColor: 'green',
            fill: false,
            tension: 0.4
          },
          {
            label: 'عميل دائم',
            data: [300, 250, 200, 150, 100, 150, 200, 250, 300, 250, 200, 150],
            borderColor: 'purple',
            fill: false,
            tension: 0.4
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          x: {
            grid: {
              display: false  // إخفاء الخطوط العمودية
            }
          },
          y: {
            beginAtZero: true,
            grid: {
              display: false  // إخفاء الخطوط الأفقية
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


  if(document.getElementById('customerStatsChart'))
  {
    const ctx = document.getElementById('visitorsChart').getContext('2d');
    const visitorsChart = new Chart(ctx, {
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

});
