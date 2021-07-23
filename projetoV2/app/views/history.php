<div class="container-fluid">

	<?php
	$this->title = "Histórico";

	if (!empty($this->errors["history"])) {
		foreach ($this->errors["history"] as $error) {
			echo $error;
		}

	} else {
		$device = $this->device;

		?>

        <div class="topnav">
            <h2 class="m-4"><?php echo $device->name; ?></h2>
        </div>
        <hr>

        <div class="row">


			<?php echo '
                    <div class="col-md-12  d-flex justify-content-center text-center">
    
                        <div class="card card-' .
				$device->state .
				'">
                            <span class="circle circle-' .
				$device->state .
				'"></span>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <img src="' .
				$device->image .
				'" width="100" height="100" alt="' .
				$device->name .
				'">
                            </div>
                    </div>
                    </div>'; ?>


        </div>
	<?php if ($device->type == "sensor") {?>

        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2 class="m-4">Gráfico</h2>
            </div>
        </div>

            <canvas id="historyChart"></canvas>

         <?php }?>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h2 class="m-4">Histórico</h2>
            </div>
        </div>
        <div class="row mb-5">

            <div class="col-md-12">
                <table class="table" id="historyTable">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Estado</th>
						<?php if ($device->type == "sensor") echo '<th scope="col">Valor</th>'; ?>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach ($this->history as $history) {
						echo '<tr>
                                    <td>' .
							$history->date .
							'</td>
                                    <td>' .
							$history->state .
							'</td>';

						if ($device->type == "sensor") {

							echo '<td>' .
								$history->value .
								'</td>';
						}

						echo '</tr>';

					} ?>
                    </tbody>
                </table>
            </div>
        </div>


	<?php } ?>

    <script type="text/javascript">
        window.onload = function () {
            renderChart(<?php echo '"' . $device->linkName . '","' . $device->type . '"' ?>);
        };

    </script>
    ;
</div>