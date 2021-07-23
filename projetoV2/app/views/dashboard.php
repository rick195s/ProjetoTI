<div class="container-fluid" id="dashboard-container">

<?php

$this->title = "Dashboard";
if (isset($this->deviceTypes)) {

	foreach ($this->deviceTypes as $deviceType) {
		echo '<div class=" text-center" style="padding-top:1%">
            <h2>' . $deviceType["title"] . '</h2>
        </div>
        <hr>';


		echo '<div class="row d-flex justify-content-center text-center">';

		if (!empty($deviceType["devices"])) {

			foreach ($deviceType["devices"] as $device) {
				echo '
                            <div class="col-md-3 m-3 d-flex justify-content-center text-center">
                                <div class="card card-' .
					$device->state .
					'">
                                <h6 style="padding-top:10%">' .
					$device->name .
					'</h6>
                                    <span class="circle circle-' .
					$device->state .
					'"></span>
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        <img src="' .
					$device->image .
					'" width="100"  alt="' .
					$device->name .
					'">
                                    </div>
                                    
                                    <h6>'; ?>
				<?php

				echo $device->value ?? "";

				echo '</h6> <h6>' .
					$device->date .
					'</h6>
				<div class="card-footer">
					<a class="mb-5" href="./history?name=' .
					$device->linkName .
					'&type='. $device->type .'">Histórico</a>
				</div>
			</div>
		</div>';
			}
		} else {
			echo "sem " . $deviceType["title"];
		}

		echo '</div>';


	}

}


?>

<?php
if ($_SESSION["priv"] == 2) {
	?>

    <div class="col-md-12 mt-5 pb-5 d-flex justify-content-center text-center">
        <div class="card">

            <div class="card-body">
                <img src="public/assets/images/foto_armazem.jpg" style="border-radius: 15px" width="100%"
                     alt="Foto Armazem">
            </div>
            <h6>Camara do Armazem</h6>
        </div>
    </div>

    <div class=" text-center" style="padding-top:1%">
        <h2>Ações</h2>
    </div>
    <hr>

    <div class="pb-5">

        <button type="submit" onclick="updateDisp('Alarme', 'atuador', null , '2' )"
                class="btn btn-primary btn-lg btn-block">Ativar Alarme
        </button>
        <button type="submit" onclick="updateDisp('Alarme', 'atuador', null , '0' )"
                class="btn btn-secondary btn-lg btn-block">Desativar Alarme
        </button>

    </div>
<?php } ?>
</div>

