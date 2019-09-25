<b> Report <?= $date; ?> </b>
<table class="table table-bordered">
	<tr>
		<td>No. </td>
		<td> Waktu</td>
		<td>Nama guru</td>
		<td>Status</td>
	</tr>
	<?php $no=1; foreach($qry as $q): ?>
	<?php 
		$data = $this->db->get_where('jadwal',['id' => $q->jadwal_id])->row();
	?>
	<tr>
		<td><?= $no++; ?></td>
		<td>
			<?= seling($data->seling_id,'dari') ?> - <?= seling($data->seling_id,'sampai'); ?>
		</td>
		<td>
			<?= guru($data->guru_id) ?>
		</td>
		<td>
			<?php if($q): ?>
				<?php if($q->status == 0): ?>
					Tidak masuk
				<?php else: ?>
					Masuk
				<?php endif; ?>
			<?php else: ?>
				Belum
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>