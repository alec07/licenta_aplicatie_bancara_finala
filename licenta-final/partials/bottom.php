
<div class="w-full container mx-auto">
    <div class="w-full bg-black">
        <div class="w-full mx-auto">
            <div class="grid grid-cols-3 gap-4">
                <div class=" p-4">
                    <p class="text-orange-200 mb-2">Utile</p>
                    <a href="login.php" class="text-gray-200">
                        Login
                    </a>
                    <p class="text-gray-200"><a href="cursvalutar.php">Tabel curs valutar</a></p>
                    <p class="text-gray-200"><a href="contactbanca.php">Contact</a></p>

                </div>
                <div class="p-4">
                    <p class="text-orange-200 mb-2">Despre bancă</p>
                    <p class="text-gray-200"><a href="istoricbanca.php">Istoric Bancă</a></p>
                    <p class="text-gray-200"><a href="organigrama.php">Organigramă</a></p>

                </div>
                <div class=" p-4">
                    <p class="text-orange-200 mb-2">CURSUL DE SCHIMB BNR Leu(RON)</p>
                    <?php
                            // URL-ul paginii cu tabelul de curs valutar de pe site-ul BNR
                            $url = 'https://www.bnr.ro/nbrfxrates.xml';

                            // Preia conținutul XML de la URL-ul specificat
                            $xml = file_get_contents($url);

                            // Caută rata de schimb pentru fiecare valută de interes (USD, EUR, RON)
                            $rates = [];
                            $rates['USD'] = getExchangeRate($xml, 'USD');
                            $rates['EUR'] = getExchangeRate($xml, 'EUR');
                            $rates['GBP'] = getExchangeRate($xml, 'GBP');

                            // Afișează rezultatul

                            echo '<span style="font-size:10px; color: gray;">' . date('F d, Y') . '</span><br>';
                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>';

                            echo '<table class="table-auto border-b">';
                            echo '<tr class="text-gray-300 border-b "><th class="px-6 ">Currency</th><th class="px-6 ">Purchase</th></tr>';

                            foreach ($rates as $currency => $rate) {
                                echo '<tr>';
                                echo '<td class="text-orange-200 border-b px-6">' . $currency . '</td>';
                                echo '<td class="text-white border-b px-6">' . $rate['purchase'] . '</td>';

                                echo '</tr>';
                            }

                            echo '</table>';


                            // Funcție pentru preluarea ratei de schimb pentru o anumită valută
                            function getExchangeRate($xml, $currency) {
                                $pattern = '/<Rate currency="' . $currency . '">(\d+\.\d+)<\/Rate>/';
                                preg_match($pattern, $xml, $matches);

                                if (isset($matches[1])) {
                                    $purchase = $matches[1];
                                } else {
                                    $purchase = 'N/A';
                                };

                                return [
                                    'purchase' => $purchase,
                                    'sale' => 'N/A', // Vânzarea nu este disponibilă în XML-ul BNR
                                ];
                            }
                            ?>
                    <p class="mt-5 text-zinc-500 text-xs"><a href="cursvalutar.php">Vezi tot tabelul -></a></p>

                </div>
            </div>

        </div>
    </div>
</div>
