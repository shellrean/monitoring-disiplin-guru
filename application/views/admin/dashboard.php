 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Dashboard app
      </div>
      <input type="hidden" name="base" id="base_url" value="<?= base_url() ?>">
      <div class="card-body">
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
		  	<table class="table table-responsive-sm table-bordered table-sm" id="appTable">
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
							<?php else: ?>
								<i class="icon-check text-success"></i>
							<?php endif; ?>
						<?php else: ?>
							<i class="icon-info text-warning"></i>
						<?php endif; ?>
					</span>
					<a href="javacript:0" data-toggle="tooltip" onclick="show(<?= $t->id ?>)" data-jadwal="<?= $t->id ?>" class="btn btn-sm badge-light show" title="<?= guru($t->guru_id) ?>"><?= kelas($t->kelas_id) ?></a>
          		
	          		<?php endforeach; ?>
	          		</td>
	          	</tr>
	          <?php endforeach; ?>
	          </tbody>
	        </table>
		  </div>
		  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
		  	<table class="table table-responsive-sm table-bordered table-sm" id="appTable2">
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
          			<?php foreach($dat as $t): ?>
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
							<?php else: ?>
								<i class="icon-check text-success"></i>
							<?php endif; ?>
						<?php else: ?>
							<i class="icon-info text-warning"></i>
						<?php endif; ?>
					</span>
					<a href="javacript:0" data-toggle="tooltip" onclick="show(<?= $t->id ?>)" data-jadwal="<?= $t->id ?>" class="btn btn-sm badge-light show" title="<?= guru($t->guru_id) ?>"><?= kelas($t->kelas_id) ?></a>
          		
	          		<?php endforeach; ?>
	          		</td>
	          	</tr>
	          <?php endforeach; ?>
	          </tbody>
	        </table>
		  </div>
		  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
		  	<table class="table table-responsive-sm table-bordered table-sm" id="appTable3">
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
							<?php else: ?>
								<i class="icon-check text-success"></i>
							<?php endif; ?>
						<?php else: ?>
							<i class="icon-info text-warning"></i>
						<?php endif; ?>
					</span>
					<a href="javacript:0" data-toggle="tooltip" onclick="show(<?= $t->id ?>)" data-jadwal="<?= $t->id ?>" class="btn btn-sm badge-light show" title="<?= guru($t->guru_id) ?>"><?= kelas($t->kelas_id) ?></a>
          		
	          		<?php endforeach; ?>
	          		</td>
	          	</tr>
	          <?php endforeach; ?>
	          </tbody>
	        </table>
		  </div>
		</div>
      </div>
      <div class="card-footer">
      	<small>
      		<i>Informasi:</i>
      	</small> <br>
      	<small><i class="icon-info text-info"></i> 
      	Tahan mouse di atas button kelas untuk melihat nama guru</small> <br>
      	
      	<small><i class="icon-info text-warning"></i>
      		Data belum di simpan
      	</small> <br>
      	<small><i class="icon-close text-danger"></i>
      		Guru tidak masuk
      	</small> <br>
      	
      	<small><i class="icon-check text-success"></i>
      		Guru masuk
      	</small>
      	
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
          <h5 class="modal-title">Detail Jadwal</h5>
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
	function show(id) {
	    // console.log('oke')
		url = $('#base_url').val();

// 	    sekolah_id = $('#sekolah_id').val()
// 	    tanggal	= $('#tanggal').val()
	    jadwal_id = id
	    // console.log(jadwal_id)
	    showLoading()

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
	    		$('#jadwal_id').val(`${obj.jadwal_id}`)
	    		if(obj.lapor_id  != 0) {
	    			$('#lapor_id').val(`${obj.lapor_id}`)
	    		}
	    		if(obj.keterangan != null) {

	    		$('#Keterangan').val(`${obj.keterangan}`)
	    		}
	    	}
	    	
	    })
	    hideLoading()
	    $('#modal-check').modal('show')
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
	})
</script>