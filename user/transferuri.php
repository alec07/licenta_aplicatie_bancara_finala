<?php
session_start();
include('includes/db.inc.php');
?>
<?php require('partials/header.php') ?>
<?php require('partials/navbar.php') ?>

<div class="flex flex-col w-screen h-screen overflow-auto text-gray-700 ">

    <!-- nav -->
    <div class="absolute top-0 left-0 w-full">
        <div class="w-full max-w-6xl mx-auto px-4">
            <div class="w-full flex items-center justify-between py-5">
                <div class="flex-1 flex items-center">
                    <a href="dashboard.user.php">CeloBank</a>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-end">
                        <a href="dashboard.user.php"><button type="">x</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content -->
    <div class=" w-full pt-20  align-center justify-center">
        <div class="w-full max-w-6xl mx-auto ">
            <div class="text-center">
                <h2 class="text-4xl">Tranzactie noua</h2>
                <form action="includes/procesare_formular_transferuri.php" method="POST">
                    <div class="mt-10">
                        <input  type="text" placeholder="Beneficiari si conturi proprii"  name="nume_beneficiar"
                            class=" mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" required />
                        <input type="text" placeholder="Cont Beneficiar" name="iban_beneficiar"
                            class=" mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]"
                            required />
                        <input type="number" placeholder="Suma" name="suma_transfer" min="0" step="0.01" required
                            class=" mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" />
                        <input type="text" placeholder="Detalii (obligatoriu)" name="detalii_transfer"
                            class=" mb-5 border-form-stroke text-body-color placeholder-body-color focus:border-primary active:border-primary w-full rounded-lg border-[1.5px] py-3 px-5 font-medium outline-none transition disabled:cursor-default disabled:bg-[#F5F7FD]" required/>
                    </div>
                    <button class="px-8 py-2 rounded-lg bg-violet-500 text-white" type="submit"
                        name="submit">Transfera</button>
                </form>

            </div>
        </div>

    </div>

    <?php require('partials/footer.php') ?>