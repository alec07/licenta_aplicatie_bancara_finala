<!-- <?php include('include/db.inc.php'); ?>
<?php require('partials/head.php') ?>
<?php require('partials/sidebar.php')?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="w-full max-w-6xl min-h-screen mx-auto bg-white">
hh
        </div>
    </div>
</div>

<?php require('partials/footer.php') ?> -->

<?php include('include/db.inc.php'); ?>
<?php require('partials/head.php') ?>
<?php require('partials/sidebar.php')?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">
    <div class="p-4 sm:ml-64">
        <div class="w-full max-w-6xl min-h-screen mx-auto bg-white">
            <div class="container mx-auto mt-8">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold">Depozite curente</h2>
                    <div class="flex items-center">
                        <span class="mr-2">Perioadă:</span>
                        <select class="px-2 py-1 border border-gray-400 rounded">
                            <option>Toate</option>
                            <option>Ultima lună</option>
                            <option>Ultimul trimestru</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8">
                    <table class="w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Număr depozit</th>
                                <th class="py-2 px-4 border-b">Titular</th>
                                <th class="py-2 px-4 border-b">Sumă</th>
                                <th class="py-2 px-4 border-b">Durată</th>
                                <th class="py-2 px-4 border-b">Dobândă</th>
                                <th class="py-2 px-4 border-b">Data deschidere</th>
                                <th class="py-2 px-4 border-b">Stare</th>
                                <th class="py-2 px-4 border-b">Acțiuni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b">001</td>
                                <td class="py-2 px-4 border-b">John Doe</td>
                                <td class="py-2 px-4 border-b">$10,000</td>
                                <td class="py-2 px-4 border-b">1 an</td>
                                <td class="py-2 px-4 border-b">2%</td>
                                <td class="py-2 px-4 border-b">2023-01-01</td>
                                <td class="py-2 px-4 border-b">Activ</td>
                                <td class="py-2 px-4 border-b">
                                    <button class="text-blue-500 mr-2">Modificare</button>
                                    <button class="text-red-500">Ștergere</button>
                                </td>
                            </tr>
                            <!-- Mai multe rânduri de depozite -->
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-semibold">Adăugare depozit nou</h3>
                    <form class="mt-4">
                        <div class="flex items-center">
                            <label for="sum" class="mr-2">Sumă:</label>
                            <input id="sum" type="number" class="px-2 py-1 border border-gray-400 rounded">
                        </div>
                        <!-- Mai multe câmpuri pentru detalii despre depozit -->
                        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Adăugare
                            depozit</button>
                    </form>
                </div>
            </div>
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold">Depozite curente</h2>
                <div class="flex items-center">
                    <span class="mr-2">Perioadă:</span>
                    <select class="px-2 py-1 border border-gray-400 rounded">
                        <option>Toate</option>
                        <option>Ultima lună</option>
                        <option>Ultimul trimestru</option>
                    </select>
                </div>
            </div>

            <div class="mt-8">
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-lg font-semibold">Sumar depozite curente</h3>
                    <div class="mt-4">
                        <p class="text-gray-600">Număr total de depozite:</p>
                        <p class="text-2xl font-semibold">500</p>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-600">Suma totală a depozitelor:</p>
                        <p class="text-2xl font-semibold">$10,000,000</p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold">Grafic creștere depozite</h3>
                <canvas id="chart"></canvas>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold">Filtrare și sortare</h3>
                <div class="flex mt-4">
                    <div class="mr-4">
                        <label for="filter-amount" class="block mb-2">Filtrare după sumă:</label>
                        <select id="filter-amount" class="px-2 py-1 border border-gray-400 rounded">
                            <option>Toate</option>
                            <option>Peste $10,000</option>
                            <option>Peste $50,000</option>
                            <option>Peste $100,000</option>
                        </select>
                    </div>
                    <div class="mr-4">
                        <label for="filter-duration" class="block mb-2">Filtrare după durată:</label>
                        <select id="filter-duration" class="px-2 py-1 border border-gray-400 rounded">
                            <option>Toate</option>
                            <option>Peste 1 an</option>
                            <option>Peste 2 ani</option>
                            <option>Peste 5 ani</option>
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="block mb-2">Sortare:</label>
                        <select id="sort" class="px-2 py-1 border border-gray-400 rounded">
                            <option>Număr depozit (ascendent)</option>
                            <option>Număr depozit (descendent)</option>
                            <option>Sumă (ascendent)</option>
                            <option>Sumă (descendent)</option>
                            <option>Durată (ascendent)</option>
                            <option>Durată (descendent)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-semibold">Înregistrări și rapoarte</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="text-lg font-semibold">Raport financiar</h4>
                        <p class="text-gray-600">Generați un raport financiar detaliat pentru depozitele curente.</p>
                        <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Generați raport</button>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="text-lg font-semibold">Extras de cont</h4>
                        <p class="text-gray-600">Generați un extras de cont pentru un depozit specific.</p>
                        <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Generați extras</button>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="text-lg font-semibold">Istoric depozite</h4>
                        <p class="text-gray-600">Vizualizați istoricul complet al depozitelor.</p>
                        <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Vizualizați istoricul</button>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="text-lg font-semibold">Raport lunar</h4>
                        <p class="text-gray-600">Generați un raport lunar pentru depozitele curente.</p>
                        <button class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Generați raport</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Inițializarea și configurarea graficului utilizând Chart.js
    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun'],
            datasets: [{
                label: 'Depozite',
                data: [50, 60, 55, 70, 65, 80],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                tension: 0.2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
    <?php require('partials/footer.php') ?>