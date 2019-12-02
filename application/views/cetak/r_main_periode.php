<h4><?= $sekolah->nama_sekolah; ?></h4>
<h5> Periode <?= todate($dari); ?> - <?= todate($sampai) ?> </h5> <br>
<table class="table table-bordered">
	<tr>
		<td>No. </td>
		<td>Tanggal</td>
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
		<td><?= todate($q->tanggal) ?></td>
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
				<?php elseif($q->status == 3): ?>
					Izin
				<?php elseif($q->status == 4): ?>
					Sakit
				<?php elseif($q->status == 5): ?>
					Dinas luar
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
			<td colspan="4"><i>Tidak ada data masuk pada periode ini</i></td>
		</tr>

	<?php endif; ?>
</table>