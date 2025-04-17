<?php
require_once "../header.php";

require_once '../controller/db.php';

// Regrouper les inscriptions par jour
$stmt = $pdo->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m-%d') as jour, COUNT(*) as total 
    FROM users 
    GROUP BY jour
    ORDER BY jour ASC
");

$labels = [];
$data = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $labels[] = $row['jour'];
    $data[] = $row['total'];
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="flex min-h-screen">
    <!-- NAVBAR LATÉRALE -->
    <?php require __DIR__ . "/navbar.php"; ?>

    <!-- CONTENU PRINCIPAL -->
    <main class="flex-1 flex flex-col items-center justify-center p-10">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue sur le tableau de bord 👋</h1>
            <p class="text-lg text-gray-600">Utilisez le menu à gauche pour gérer votre site.</p>
        </div>
        <div class="w-full max-w-3xl mt-10">
            <canvas id="userGrowthChart"></canvas>
        </div>
    </main>
</div>

<?php
require __DIR__ . "/footer.php";
?>
<script>
    const ctx = document.getElementById('userGrowthChart').getContext('2d');
    const userGrowthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Inscriptions par jour',
                data: <?= json_encode($data) ?>,
                fill: true,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>