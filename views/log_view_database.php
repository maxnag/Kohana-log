<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="http://tablesorter.ru/jquery.tablesorter.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://tablesorter.ru/themes/blue/style.css" />
<style type="text/css">
	table#log_table td.error { background: #f96; }
	table#log_table td.info { background: #9cf; }
</style>
<script>
	$(document).ready(function() {
		$('#log_table').tablesorter({
			/*
			headers: {
				0: {sorter: true},
				1: {sorter: true},
				2: {sorter: false},
				3: {sorter: true},
				4: {sorter: true},
				5: {sorter: true},
				6: {sorter: false},
				7: {sorter: false}
			},
			*/
			widgets: ['zebra']
		});
	});
</script>

<?php //echo Helper_HTML::anchor('/log/download/'.$date, 'Download log');?>

<table id="log_table" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
	<thead>
		<tr>
			<th>time</th>
			<th>level</th>
			<th>message</th>
			<th>client</th>
			<th>uri</th>
			<th>referer</th>
			<th>agent</th>
			<th>cookie</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($logs as $log): ?>
		<tr>
			<td><?php echo HTML::chars($log->time) ?></td>
			<td <?php echo 'class="'.HTML::chars(strtolower($log->level)).'"'?>><?php echo HTML::chars($log->level) ?></td>
			<td><?php echo nl2br($log->message)?></td>
			<td><?php echo HTML::chars($log->client)?></td>
			<td><?php echo HTML::chars($log->uri)?></td>
			<td><?php echo HTML::chars($log->referer)?>&nbsp;</td>
			<td><?php echo HTML::chars($log->agent)?></td>
			<td><?php echo nl2br(HTML::chars($log->cookie))?></td>
		</tr>
	<?php endforeach ?>
	</tbody>
</table>
