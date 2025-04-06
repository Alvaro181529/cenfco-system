<?php require 'template/head.php' ?>
<?php require 'template/navbar.php' ?>
<main id="hero" class="container">
    <div class="row gap-4">
        <div class="card mb-3 col" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <a href="/dashboard/docentes">
                        <div class="card-body">
                            <h5 class="card-title">Docentes</h5>
                            <p class="card-text"><?php echo $cantidadDocentes ?></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="card mb-3 col" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <a href="/dashboard/estudiantes">
                        <div class="card-body">
                            <h5 class="card-title">Estudiantes</h5>
                            <p class="card-text"><?php echo $cantidadEstudiantes ?></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="card mb-3 col" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <a href="/dashboard/cursos">
                        <div class="card-body">
                            <h5 class="card-title">Cursos</h5>
                            <p class="card-text"><?php echo $cantidadCursos ?></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="card mb-3 col" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/assets/cenefco_grande.png" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <a href="/dashboard/inventario">
                        <div class="card-body">
                            <h5 class="card-title">Inventario</h5>
                            <p class="card-text"><?php echo $cantidadInventario ?></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Nueva sección para la gráfica -->
    <div class="row">
        <div class="col">
            <h5>Gráfico de Docentes</h5>
            <canvas id="chartDocentes"></canvas> <!-- Aquí se dibujará la gráfica -->
        </div>
        <div class="col">
            <h5>Gráfico de Docentes</h5>
            <canvas id="chartEdu"></canvas> <!-- Aquí se dibujará la gráfica -->
        </div>
    </div>

</main>
<script>
    var ctx = document.getElementById('chartDocentes').getContext('2d');
    var ctxEdu = document.getElementById('chartEdu').getContext('2d');
    var chartDocentes = new Chart(ctx, {
        type: 'bar', // Tipo de gráfica (en este caso, barras)
        data: {
            labels: ['Docentes'], // Aquí van las categorías, por ejemplo: Docentes
            datasets: [{
                label: 'Cantidad de Docentes',
                data: [<?php echo $cantidadDocentes; ?>], // Pasas la variable PHP aquí
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color del fondo de las barras
                borderColor: 'rgba(54, 162, 235, 1)', // Color del borde de las barras
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    var chartEdu = new Chart(ctxEdu, {
        type: 'bar', // Tipo de gráfica (en este caso, barras)
        data: {
            labels: ['Docentes'], // Aquí van las categorías, por ejemplo: Docentes
            datasets: [{
                label: 'Cantidad de Docentes',
                data: [<?php echo $cantidadEstudiantes; ?>], // Pasas la variable PHP aquí
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color del fondo de las barras
                borderColor: 'rgba(54, 162, 235, 1)', // Color del borde de las barras
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php require 'template/foot.php' ?>