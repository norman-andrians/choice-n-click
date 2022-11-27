const salesChart = document.getElementById("sales-chart");
const prodChart = document.getElementById("prod-chart");

let delayed;

let salesConf = {
    type: "bar",
    data: {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
        datasets: [{
            label: "Data Penjualan Pada 12 November 2022",
            data: [4000, 2000, 5000, 3000, 8000, 4000, 10000],
            backgroundColor: "#6C4AB6"
        }]
    },
    options: {
        animation: {
          onComplete: () => {
            delayed = true;
          },
          delay: (context) => {
            let delay = 0;
            if (context.type === 'data' && context.mode === 'default' && !delayed) {
              delay = context.dataIndex * 300 + context.datasetIndex * 100;
            }
            return delay;
          },
        },
        scales: {
          x: {
            stacked: true,
          },
          y: {
            stacked: true
          }
        }
    }
}

let prodConf = {
    type: "doughnut",
    data: {
        labels: ["Milk Tea", "Ed Tea", "Sus Tea"],
        datasets: [{
            label: "Data Penjualan Pada 12 November 2022",
            data: [8, 4, 5],
            backgroundColor: ["#15bf42", "#ffc226", "#2638ff"]
        }]
    }
}

var slChart = new Chart(salesChart, salesConf);
var productChart = new Chart(prodChart, prodConf);