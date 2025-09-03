<?php
// Função para traduzir a data usando DateTime e IntlDateFormatter
if (!function_exists('translateDate')) {
    function translateDate($date, $format = 'EEEE, d de MMMM de yyyy') {
        $dateObj = new DateTime($date);
        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo', // Defina o fuso horário correto, se necessário
            IntlDateFormatter::GREGORIAN
        );
        $formatter->setPattern($format);
        return $formatter->format($dateObj);
    }
}

if (!function_exists('translateMonth')) {
    function translateMonth($date) {
        return translateDate($date, 'MMMM');
    }
}

if (!function_exists('translateDay')) {
    function translateDay($date) {
        return translateDate($date, 'EEEE, d');
    }
}
?>

<div class="table-responsive" id="print_area">
	<table class="table table-striped table-hover" id="myTable">
		<thead>
			<tr class="tableHeader">
				<?php if(!empty($year) && !empty($month) && isset($_REQUEST['d']) && !empty($_REQUEST['d'])): ?>
					<th><?= lang('order_id');?></th>
				<?php else: ?>
					<th><?= lang('date');?></th>
				<?php endif ?>
				<th><?= lang('total_order');?></th>
				<th><?= lang('item_sales_count');?></th>
				<th><?= lang('earnings');?></th>
			</tr>
		</thead>
		<tbody>
			<?php $total_order = $total_item = $total_price = 0; ?>
			<?php foreach ($earning_list as $row): ?>
				<?php if(isset($row['completed_time']) && !empty($row['completed_time'])): ?>
					<?php 
						if(!empty($year) && !empty($month) && isset($_REQUEST['d']) && !empty($_REQUEST['d'])):
							$url = base_url("admin/restaurant/get_item_list_by_order_id/{$row['uid']}");
							$title = '#'.$row['uid'];
						else:
							if(empty($year) && empty($month)):
								$url = base_url("admin/reports/earnings/".year($row['completed_time']).'/0');
								$title = year($row['completed_time']);
							elseif(!empty($year) && empty($month)):
								$url = base_url("admin/reports/earnings/".year($row['completed_time'])."/".month($row['completed_time']));
								$title = translateMonth($row['completed_time']);
							elseif(!empty($year) && !empty($month)):
								$url = base_url("admin/reports/earnings/".year($row['completed_time'])."/".month($row['completed_time']).'?d='.day($row['completed_time']));
								$title = translateDay($row['completed_time']);
							endif;
						endif;
					 ?>
					<tr>
						<td><a href="<?= $url;?>"><?= $title;?></a></td>
						<td><?= $row['total_order'];?></td>
						<td><?= $row['total_item'];?></td>
						<td><?= currency_position($row['total_price'],restaurant()->id);?></td>
					</tr>
					<?php 
						$total_order += $row['total_order'];
						$total_item +=$row['total_item'];
						$total_price += $row['total_price'];
					 ?>
				<?php endif;?>	
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr class="tableTotal">
				<td><?= lang('total');?></td>
				<td><?= $total_order;?></td>
				<td><?= $total_item;?></td>
				<td><?= currency_position($total_price,restaurant()->id);?></td>
			</tr>
		</tfoot>
	</table>
</div>