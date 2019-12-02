 <div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Dashboard app

        <a href="<?= base_url('cctv/pantau/'.user()->sekolah_id); ?>" class="btn btn-success btn-sm pull-right">Pantau CCTV</a>
      </div>
      <input type="hidden" name="base" id="base_url" value="<?= base_url() ?>">
      <div class="card-body">
      	<?= $this->session->flashdata('message'); ?>
      	<ul class="nav nav-tabs" id="myTab" role="tablist">
		  <li class="nav-item">
		    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Tingkat 10</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Tingkat 11</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Tingkat 12</a>
		  </li>
		</ul>
		<div class="tab-content" id="myTabContent">
		  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
		  	<div class="table-responsive-sm">
		  	<table class="table table-bordered table-sm" id="appTable" style="min-width: 620px">
			  	<thead>
			  		<tr>
			  			<td>Interval</td>
			  			<td>Jadwal</td>
			  		</tr>
			  	</thead>
	          	<tbody>
	          	<?php foreach($data as $d): ?>
	          	<tr>
	          		<td width="150px">
	          			<span class="badge badge-success"><?= seling($d->seling_id, 'dari') ?></span> 
	          			<span class="badge badge-danger"><?= seling($d->seling_id, 'sampai') ?></span>
	          		</td>
	          		<?php
	          			$id_sek = user()->sekolah_id;
		          		$day 	= date('N', time());
	          			$dat 	= $this->Jadwal_model->get_by_day($id_sek, $day, $d->seling_id)->result();
          			?> 
          			<td>
          			<?php foreach($dat as $t): ?>
	          		<?php 
		          	if (kelas($t->kelas_id,'tingkat') != 10) { 
				        continue;
				    } ?>
          			<?php
						$date = date('Y-m-d', time());
						$cek = $this->Lapor_model->get_by_date_id($id_sek,$date, $t->id)->row();
          			?>
					<span class="badge">
						<?php if($cek): ?>
							<?php if($cek->status == 0): ?>
								<i class="icon-close text-danger"></i>
							<?php elseif($cek->status == 2): ?>
								<i class="icon-clock text-warning"></i>
							<?php elseif($cek->status == 3): ?>
								<i class="icon-close text-info"></i>
							<?php elseif($cek->status == 4): ?>
								<i class="icon-close text-warning"></i>
							<?php elseif($cek->status == 5): ?>
								<i class="icon-close text-success"></i>
							<?php else: ?>
								<i class="icon-check text-success"></i>
							<?php endif; ?>
						<?php else: ?>
							<i class="icon-info text-warning"></i>
						<?php endif; ?>
					</span>
					<a href="javascript:void(0)" data-toggle="tooltip" onclick="show(<?= $t->id ?>,`<?= guru($t->guru_id) ?>`)" data-jadwal="<?= $t->id ?>" class="btn btn-sm badge-light show" title="<?= guru($t->guru_id) ?>"><?= kelas($t->kelas_id) ?></a>
          		
	          		<?php endforeach; ?>
	          		</td>
	          	</tr>
	          <?php endforeach; ?>
	          </tbody>
	        </table>
	    	</div>
		  </div>
		  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		  	<div class="table-responsive-sm">
		  	<table class="table table-bordered table-sm" id="appTable2" style="min-width: 620px">
			  	<thead>
			  		<tr>
			  			<td>Interval</td>
			  			<td>Jadwal</td>
			  		</tr>
			  	</thead>
	          	<tbody>

	          	<?php foreach($data as $d): ?>
	          	<tr>
	          		<td width="150px">
	          			<span class="badge badge-success"><?= seling($d->seling_id, 'dari') ?></span> 
	          			<span class="badge badge-danger"><?= seling($d->seling_id, 'sampai') ?></span>
	          		</td>
	          		<?php
	          			$id_sek = user()->sekolah_id;
		          		$day 	= date('N', time());
	          			$dat1 	= $this->Jadwal_model->get_by_day($id_sek, $day, $d->seling_id)->result();
          			?>
          			<td>
          			<?php foreach($dat1 as $t): ?>
	          		<?php 
		          	if (kelas($t->kelas_id,'tingkat') != 11) { 
				        continue;
				    } ?>
          			<?php
						$date = date('Y-m-d', time());
						$cek = $this->Lapor_model->get_by_date_id($id_sek,$date, $t->id)->row();
          			?>
					<span class="badge">
						<?php if($cek): ?>
							<?php if($cek->status == 0): ?>
								<i class="icon-close text-danger"></i>
							<?php elseif($cek->status == 2): ?>
								<i class="icon-clock text-warning"></i>
							<?php elseif($cek->status == 3): ?>
								<i class="icon-close text-info"></i>
							<?php elseif($cek->status == 4): ?>
								<i class="icon-close text-warning"></i>
							<?php elseif($cek->status == 5): ?>
								<i class="icon-close text-success"></i>
							<?php else: ?>
								<i class="icon-check text-success"></i>
							<?php endif; ?>
						<?php else: ?>
							<i class="icon-info text-warning"></i>
						<?php endif; ?>
					</span>
					<a href="javascript:void(0)" data-toggle="tooltip" onclick="show(<?= $t->id ?>,`<?= guru($t->guru_id) ?>`)" data-jadwal="<?= $t->id ?>" class="btn btn-sm badge-light show" title="<?= guru($t->guru_id) ?>"><?= kelas($t->kelas_id) ?></a>
          		
	          		<?php endforeach; ?>
	          		</td>
	          	</tr>
	          <?php endforeach; ?>
	          </tbody>
	        </table>
	    	</div>
		  </div>
		  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
		  	<div class="table-responsive-sm">
		  	<table class="table table-bordered table-sm" id="appTable3" style="min-width: 620px">
			  	<thead>
			  		<tr>
			  			<td>Interval</td>
			  			<td>Jadwal</td>
			  		</tr>
			  	</thead>
	          	<tbody>
	          	<?php foreach($data as $d): ?>
	          	<tr>
	          		<td width="150px">
	          			<span class="badge badge-success"><?= seling($d->seling_id, 'dari') ?></span> 
	          			<span class="badge badge-danger"><?= seling($d->seling_id, 'sampai') ?></span>
	          		</td>
	          		<?php
	          			$id_sek = user()->sekolah_id;
		          		$day 	= date('N', time());
	          			$dat2 	= $this->Jadwal_model->get_by_day($id_sek, $day, $d->seling_id)->result();
          			?>
          			<td>
          			<?php foreach($dat2 as $t): ?>
	          		<?php 
		          	if (kelas($t->kelas_id,'tingkat') != 12) { 
				        continue;
				    } ?>
          			<?php
						$date = date('Y-m-d', time());
						$cek = $this->Lapor_model->get_by_date_id($id_sek,$date, $t->id)->row();
          			?>
					<span class="badge">
						<?php if($cek): ?>
							<?php if($cek->status == 0): ?>
								<i class="icon-close text-danger"></i>
							<?php elseif($cek->status == 2): ?>
								<i class="icon-clock text-warning"></i>
							<?php elseif($cek->status == 3): ?>
								<i class="icon-close text-info"></i>
							<?php elseif($cek->status == 4): ?>
								<i class="icon-close text-warning"></i>
							<?php elseif($cek->status == 5): ?>
								<i class="icon-close text-success"></i>
							<?php else: ?>
								<i class="icon-check text-success"></i>
							<?php endif; ?>
						<?php else: ?>
							<i class="icon-info text-warning"></i>
						<?php endif; ?>
					</span>
					<a href="javascript:void(0)" data-toggle="tooltip" onclick="show(<?= $t->id ?>,`<?= guru($t->guru_id) ?>`)" data-jadwal="<?= $t->id ?>" class="btn btn-sm badge-light show" title="<?= guru($t->guru_id) ?>"><?= kelas($t->kelas_id) ?></a>
          		
	          		<?php endforeach; ?>
	          		</td>
	          	</tr>
	          <?php endforeach; ?>
	          </tbody>
	        </table>
	    	</div>
		  </div>
		</div>
      </div>
      <div class="card-footer">
      	<span>
      		<i>Informasi:</i>
      	</span> <br>
      	<span><i class="icon-info text-info"></i> 
      	Tahan mouse di atas button kelas untuk melihat nama guru</span> <br>
      	
      	<span><i class="icon-info text-warning"></i>
      		Data belum di simpan
      	</span> <br>
      	<span><i class="icon-close text-danger"></i>
      		Guru tidak masuk
      	</span> <br>
      	<span><i class="icon-close text-warning"></i>
      		Guru sakit
      	</span> <br>
      	<span><i class="icon-close text-info"></i>
      		Guru izin
      	</span> <br>
      	<span><i class="icon-close text-success"></i>
      		Guru dinas luar
      	</span> <br>
      	
      	<span><i class="icon-check text-success"></i>
      		Guru masuk
      	</span><br>
       	<span>
      		<i class="icon-clock text-warning"></i> Guru telambat masuk kelas
      	</span>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modal-check" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="<?= base_url('panel/store') ?>" method="post" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="det">Detail Jadwal</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Status</label>
            <input type="hidden" name="jadwal_id" id="jadwal_id">
            <input type="hidden" name="lapor_id" id="lapor_id" value="0">
           	 <select class="form-control" id="status" name="status">
           	 	<option value="1">Masuk</option>
           	 	<option value="2">Telat</option>
           	 	<option value="3">Izin</option>
           	 	<option value="4">Sakit</option>
           	 	<option value="5">Dinas luar</option>
           	 	<option value="0">Tidak</option>
           	 </select>
           </div>
           <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" id="Keterangan" name="keterangan"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="tambah-simpan" class="btn btn-success">Simpan</button>
        </div>
    </div>
    </form>
  </div>
</div>

<script>
	function show(id, guru) {
		$stsr = $('#stsr').val()
			url = $('#base_url').val();
		    jadwal_id = id

		    Pace.restart();
			Pace.track(function () {
			    $.ajax({
			    	
			    	url: url+'/panel/get',
			    	type: "POST",
			    	data: {
			    		jadwal_id : jadwal_id
			    	},
			    	cache: false,
			    	success: function(res) {
			    		let obj = $.parseJSON(res)
			    		
			    		$('#status').val(`${obj.status}`)
			    		$('#jadwal_id').val(jadwal_id)

			    		if(obj.lapor_id  != 0) {
			    			$('#lapor_id').val(`${obj.lapor_id}`)
			    		}
			    		if(obj.keterangan != null) {
			    			$('#Keterangan').val(`${obj.keterangan}`)
			    		}
			    		$('#det').html(guru)
			    		$('#modal-check').modal('show')
			    	}
			    })
			})
	};
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()

		$('.check').change(function() {

	        let value = $(this).val();

	        url = $('#base_url').val();

	        $.ajax({
		        type: "POST",
		        url: url+'/panel/core',
		        data: {
		            jadwal_id: value
		        },
		        success (rest) {
		        	alert(rest.message)
		        }
		    });

	    });
	    $('#appTable').DataTable();
	    $('#appTable2').DataTable();
	    $('#appTable3').DataTable(); 
	})
</script>