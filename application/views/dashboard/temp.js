
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Student Engagement Chart
    var engagementCtx = document.getElementById('engagementChart').getContext('2d');
    var engagementChart = new Chart(engagementCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
            datasets: [{
                label: 'Course Views',
                data: [<?= implode(',', $engagement['weekly_views']) ?>],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4
            }, {
                label: 'Lesson Completions',
                data: [<?= implode(',', $engagement['weekly_completions']) ?>],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                tension: 0.4
            }, {
                label: 'Quiz Attempts',
                data: [<?= implode(',', $engagement['weekly_quiz_attempts']) ?>],
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Monthly Earnings Chart
    var earningsCtx = document.getElementById('earningsChart').getContext('2d');
    var earningsChart = new Chart(earningsCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Monthly Earnings ($)',
                data: [
                    <?php 
                    $monthlyData = array_fill(0, 12, 0);
                    foreach ($monthly_earnings as $earning) {
                        $month = intval(date('n', strtotime($earning['month']))) - 1;
                        $monthlyData[$month] = $earning['amount'];
                    }
                    echo implode(',', $monthlyData);
                    ?>
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
