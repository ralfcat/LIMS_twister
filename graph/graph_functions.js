// Fetch and load regions into the dropdown
function loadRegions() {
    console.log('Fetching regions...'); 

    fetch('/graph/get_regions.php')
        .then(response => response.json())
        .then(data => {
            const regionSelect = document.getElementById('region-select');
            data.forEach(region => {
                const option = document.createElement('option');
                option.value = region.rid;  
                option.textContent = region.region; 
                regionSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error loading regions:', error);  
        });
}

// Fetch blood stock data for the selected region and update the chart
function updateGraph() {
    const regionId = document.getElementById('region-select').value;

    if (!regionId) return;  

    fetch(`/graph/get_blood_stock.php?rid=${regionId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const bloodTypes = data.blood_types;
            const stockLevels = data.stock_levels;
            const thresholds = data.thresholds;

            const ctx = document.getElementById('bloodStockChart').getContext('2d');
            ctx.font = "30px Nunito";

            window.bloodStockChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: bloodTypes,
                    datasets: [{
                        data: stockLevels.map((level, i) => level / thresholds[i]),
                        backgroundColor: 'rgba(175, 9, 60, 1)',
                        borderColor: 'rgba(175, 9, 60, 1)',
                        borderWidth: 1,
                        borderRadius: 20,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: false,  
                    maintainAspectRatio: false,
                    scales: {
                        y: {beginAtZero: true,
                            ticks: {display: false},
                            grid: {display: false}},
                        x: {
                            font: {size: 18,
                                   Color: 'white'},
                            grid: {display: false}}},
                    plugins: {
                        legend: { display: false },
                        annotation: {
                            annotations: {
                                thresholdLine: {
                                    yMin: 1,
                                    yMax: 1,
                                    borderColor: 'black',  
                                    borderWidth: 3,
                                    label: {content: 'Threshold',
                                            enabled: true,
                                            position: 'end'}}
                            }
                        }
                    }
                }
            })
        })
        
        .catch(error => {
            console.error('Error fetching blood stock data:', error); 
        });
    }

// Load regions on page load
window.onload = loadRegions;
