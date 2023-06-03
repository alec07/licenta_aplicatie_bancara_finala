<?php include ('partials/header2.php'); ?>
<?php include ('partials/navbar2.php'); ?>

<div class="mt-20 max-w-4xl mx-auto">
    <!-- conținutul paginii -->
    <a href="index.php" class="text-gray-300 font-bold">Home</a>
    <span class="text-gray-200 mx-2">/</span>
    <a href="despreapp.php" class="text-gray-300">Welcome to CeloBank</a>
    <span class="text-gray-200 mx-2">/</span>
    <a href="ORGANIGRAMA.PHP.php" class="text-gray-300">Organigramă</a>

    <div class="mt-5 mb-5">
        <h1 class="text-orange-200 font-serif text-4xl">TABEL CURS VALUTAR</h1>
    </div>
    <div class="text-gray-500">
        <?php

// Definirea comisionului în procent
$comision = 0.5;
// URL-ul de la care se preiau datele de curs valutar de la BNR
$url = 'https://bnr.ro/nbrfxrates.xml';
// Obținerea conținutului XML de la URL
$xml = simplexml_load_file($url);
// Crearea unui array pentru a stoca ratele de schimb valutar
$rates = [];
// Iterarea prin fiecare valută din XML și preluarea ratei de schimb
foreach ($xml->Body->Cube->Rate as $rate) {
    $currency = (string) $rate['currency'];
    $value = (float) $rate;

    // Adăugarea ratei de schimb în array, aplicând comisionul
    $purchase = $value * (1 + ($comision / 100));
    $sale = $value * (1 - ($comision / 100));

    $rates[$currency] = [
        'purchase' => $purchase,
        'sale' => $sale,
    ];
}

?>

        <!-- Crearea tabelului HTML pentru afișarea cursului valutar cu comision -->
        <table>
            <tr class="border-b">
                <th scope="col" class="px-6 py-3">Currency</th>
                <th scope="col" class="px-6 py-3">Purchase</th>
                <th scope="col" class="px-6 py-3">Sale</th>
            </tr>
            <?php foreach ($rates as $currency => $rate) { ?>
            <tr class="border-b">
                <td class="px-6 py-4"><?php echo $currency; ?></td>
                <td class="px-6 py-4"><?php echo $rate['purchase']; ?></td>
                <td class="px-6 py-4"><?php echo $rate['sale']; ?></td>
            </tr>
            <?php } ?>
        </table>

    </div>
</div>

<?php include ('partials/bottom.php'); ?>
<?php include ('partials/footer.php'); ?>