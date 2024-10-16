function loadRegions() {
    console.log('Fetching regions...');
    fetch('/graph/get_regions.php')
        .then(response => response.json())
        .then(data => {
            const regionSelect = document.getElementById('region-select');
            data.forEach(region => {
                const option = document.createElement('option');
                option.value = region.rid;  
                console.log(`The current region is `);

                option.textContent = region.region; 
                if (region.rid == 12){
                    option.setAttribute("selected", "selected");

                }
                regionSelect.appendChild(option);
            });
            regionSelect.value = '12'; 
            updateGraph();
            regionSelect.addEventListener('change', updateGraph);
        })
        .catch(error => {
            console.error('Error loading regions:', error);  
        });
}

function updateGraph() {
    const regionSelect = document.getElementById('region-select');
    const regionId = regionSelect.value;
    const regionName = regionSelect.options[regionSelect.selectedIndex].text; 

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
            if (Chart.getChart("bloodStockChart")) {
                Chart.getChart("bloodStockChart")?.destroy();
            }
            window.bloodStockChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: bloodTypes,
                    datasets: [{
                        data: stockLevels.map((level, i) => level / thresholds[i]),
                        backgroundColor: 'rgba(175, 9, 60)',
                        borderColor: 'rgba(175, 9, 60)',
                        hoverBackgroundColor: 'rgba(160, 6, 53)',
                        borderWidth: 1,
                        borderRadius: 20,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: false,  
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { display: false },
                            grid: { display: false }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 18,
                                    family: 'Nunito',
                                    weight: 'bold'    
                                },
                                color: 'black'  
                            },
                            grid: { display: false }  
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: `Blood Stock Levels for Region ${regionName}`, 
                            font: { size: 18, family: 'Nunito', weight: 'bold' },
                            color: 'rgba(160, 6, 53)',
                            padding: { top: 10, bottom: 30 }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const currentUnits = stockLevels[tooltipItem.dataIndex]; 
                                    const threshold = thresholds[tooltipItem.dataIndex]; 
                                    return [
                                        `Current units: ${currentUnits}`,
                                        `Threshold: ${threshold}`
                                    ];
                                }
                            },
                            titleFont: {
                                family: 'Nunito', 
                                size: 16
                            },
                            bodyFont: {
                                family: 'Nunito',
                                size: 14
                            }
                        },
                        annotation: {
                            annotations: {
                                thresholdLine: {
                                    yMin: 1,
                                    yMax: 1,
                                    borderColor: 'black',  
                                    borderWidth: 3,
                                    label: {
                                        content: 'Threshold',
                                        enabled: true,
                                        position: 'end'
                                    }
                                },
                                thresholdInfo: {
                                    type: 'label', 
                                    xValue: 0.5, 
                                    yValue: 1, 
                                    content: 'Threshold',
                                    enabled: true,
                                    font: {
                                        size: 15, 
                                        family: 'Nunito',
                                        style: 'normal', 
                                        weight: 'bold'
                                    },
                                    color: 'black',
                                    xAdjust: 10,  
                                    yAdjust: -10
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching blood stock data:', error); 
        });
}

window.onload = loadRegions;
