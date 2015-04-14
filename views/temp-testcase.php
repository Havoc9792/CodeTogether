<?php
$testcaseAPI = new Testcase();
?>

<div class="panel panel-transparent">	
	<div class="panel-body no-padding">
		<div class="table-responsive">
			<table class="table table-hover table-condensed" id="">
				<thead>
					<tr>
						<th style="width:30%">Testcase</th>
						<th style="width:50%">Type</th>
						<th style="width:20%"><i class="fa fa-gear"></i></th>						
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($testcaseAPI->get($assignment_id, false) as $testcase):	
					?>
					<tr data-testcase-id="<?= $testcase['testcase_id'] ?>">
						<td class="v-align-middle semi-bold"><?= $testcase['testcase_id'] ?></td>
						<td class="v-align-middle"><?= $testcase['type'] ?></td>
						<td class="indicator v-align-middle semi-bold"><i class="fa fa-circle-o-notch fa-spin info"></i></td>						
					</tr>
					<?php
					endforeach;	
					?>	
					<!--
					<tr data-testcase-id="2">
						<td class="v-align-middle semi-bold">1</td>
						<td class="v-align-middle">Logic Error</td>
						<td class="indicator v-align-middle semi-bold"><i class="fa fa-check-circle success"></i></td>						
					</tr>
					
					<tr data-testcase-id="3">
						<td class="v-align-middle semi-bold">1</td>
						<td class="v-align-middle">Logic Error</td>
						<td class="indicator v-align-middle semi-bold"><i class="fa fa-exclamation-triangle warning"></i></td>						
					</tr>	
					
					<tr data-testcase-id="4">
						<td class="v-align-middle semi-bold">1</td>
						<td class="v-align-middle">Logic Error</td>
						<td class="indicator v-align-middle semi-bold"><i class="fa fa-times-circle danger"></i></td>						
					</tr>	
					-->																	
				</tbody>
			</table>
		</div>
	</div>
</div>
