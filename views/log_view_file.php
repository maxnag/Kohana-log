<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="http://tablesorter.ru/jquery.tablesorter.min.js"></script>
<script>
    $(function() {
        $('#log_table').tablesorter({
            /*
             headers: {
             0: {sorter: true},
             1: {sorter: true},
             2: {sorter: false},
             3: {sorter: true}
             },
             */
            widgets: ['zebra']
        });
    });
</script>
<link rel="stylesheet" type="text/css" href="http://tablesorter.ru/themes/blue/style.css" />
<style type="text/css">
    table#log_table td.error { background: #f96; }
    table#log_table td.info { background: #9cf; }
</style>

<?php echo HTML::anchor('/log/download/' . $date, 'Download log'); ?>

<table id="log_table" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
    <thead>
        <tr>
            <th>time</th>
            <th>level</th>
            <th>message</th>
            <th>uri</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?php echo HTML::chars(isset($log['time']) ? $log['time'] : '') ?></td>
                <td class="<?php echo HTML::chars(strtolower(isset($log['level']) ? $log['level'] : '')) ?>"><?php echo HTML::chars(isset($log['level']) ? $log['level'] : '') ?></td>
                <td><?php echo isset($log['message']) ? str_replace("*", "<br />", $log['message']) : '' ?></td>
                <td><?php echo HTML::chars(isset($log['uri']) ? rawurldecode($log['uri']) : '') ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

