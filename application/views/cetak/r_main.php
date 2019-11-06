<h4><?= $sekolah->nama_sekolah; ?></h4>
<h5> Report <?= todate($date); ?> </h5> <br>
<table class="table table-bordered">
	<tr>
		<td>No. </td>
		<td>Waktu</td>
		<td>NIP</td>
		<td>Nama guru</td>
		<td>Status</td>
		<td>Keterangan</td>
	</tr>
	<?php 
	if($qry != null): 
	$no=1; foreach($qry as $q): ?>
	<?php 
		$data = $this->db->get_where('jadwal',['id' => $q->jadwal_id])->row();
		if($data == null) {
			continue;
		}
	?>
	<tr>
		<td><?= $no++; ?></td>
		<td>
			<?= seling($data->seling_id,'dari') ?> - <?= seling($data->seling_id,'sampai'); ?>
		</td>
		<td>
			<?= guru($data->guru_id,'nip'); ?>
		</td>
		<td>
			<?= guru($data->guru_id) ?>
		</td>
		<td>
			<?php if($q): ?>
				<?php if($q->status == 0): ?>
					Tidak masuk
				<?php elseif($q->status == 2): ?>
					Telambat
				<?php else: ?>
					Masuk
				<?php endif; ?>
			<?php else: ?>
				Belum
			<?php endif; ?>
		</td>
		<td>
			<?= $q->keterangan; ?>
		</td>
	</tr>
	<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="4"><i>Semua guru masuk hari ini</i></td>
		</tr>

	<?php endif; ?>
</table>