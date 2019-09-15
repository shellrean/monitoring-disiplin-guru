 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar user 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah user</button>
      </div>
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="table-user">
          <thead>
            <tr>
              <th>#</th>
              <th>Login</th>
              <th>Nama</th>
              <th>Status</th>
              <th>ID Sekolah</th>
              <th>Aksi</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <button type="button" id="btn-edit-hapus" class="btn btn-primary btn-sm">Hapus</button>
        <button type="button" id="btn-edit-pilih" class="btn btn-danger btn-sm pull-right">Pilih Semua</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modal-tambah" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-tambah" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah user</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
          	<label>Sekolah</label>
          	<select class="form-control" name="sekolah_id" id="sekolah_id">	
          		<?php foreach($sekolah as $s): ?>
          			<option value="<?= $s->id ?>"><?= $s->nama_sekolah ?></option>
          		<?php endforeach; ?>
          	</select>
          </div>
          <div class="form-group">
            <label>User login</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nama">
          </div>
          <div class="form-group">
          	<label>Status</label>
          	<select class="form-control" name="is_active" id="is_active">
				<option value="1">AKTIF</option>
          		<option value="1">TIDAK AKTIF</option>
          	</select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="tambah-simpan" class="btn btn-success">Tambah</button>
        </div>
    </div>
    </form>
  </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="modal-edit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-tambah" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit user</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
          	<label>Sekolah</label>
          	<select class="form-control" name="sekolah_id" id="sekolah_id">	
          		<?php foreach($sekolah as $s): ?>
          			<option value="<?= $s->id ?>"><?= $s->nama_sekolah ?></option>
          		<?php endforeach; ?>
          	</select>
          </div>
          <div class="form-group">
            <label>User login</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nama">
          </div>
          <div class="form-group">
          	<label>Status</label>
          	<select class="form-control" name="is_active" id="is_active">
				<option value="1">AKTIF</option>
          		<option value="1">TIDAK AKTIF</option>
          	</select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="tambah-simpan" class="btn btn-success">Tambah</button>
        </div>
    </div>
    </form>
  </div>
</div>
<script>
	function refresh_table() {
		$('#table-user').dataTable().fnReloadAjax();
	}
	function hideLoading()
	{
	  $('#modal-proses').on('shown.bs.modal', function(e) {
	    $('#modal-proses').modal('hide')
	  })
	}
	function tambah()
	{
	  $('#form-pesan').html('');
	  $('#sekolah_id').val('');
	  $('#username').val('');
	  $('#name').val('');
	  $('#password').val('');
	  $('#modal-tambah').modal('show');
	}

	$(function(){
		$('#form-tambah').submit(function(e){
	      e.preventDefault();

	      $('#modal-proses').modal('show');
	      $.ajax({
	        url:"<?= base_url('user/tambah') ?>",
	        type:"POST",
	        data:$('#form-tambah').serialize(),
	        cache: false,
	        success: function(res) {
	          let obj = $.parseJSON(res);
	          if(obj.status == 1) {
	            refresh_table();
	            hideLoading();
	            $("#modal-tambah").modal('hide');
	            notify_success(obj.pesan);
	            $
	          } else {
	            hideLoading();
	            $("#form-pesan").html(pesan_err(obj.pesan));
	          }
	        }
	      })
	      return false;
	    })
		$('#table-user').DataTable({
			"paging" : true,
			"iDisplayLength":10,
			"bProcessing" : true,
			"bServerSide" : true,
			"searching" : true,
			"aoColumns" : [
			  {"bSearchable": false, "bSortable": false, "sWidth":"20px"},
		      {"bSearchable": false, "bSortable": false},
		      {"bSearchable": false, "bSortable": false},
		      {"bSearchable": false, "bSortable": false},
		      {"bSearchable": false, "bSortable": false},
		      {"bSearchable": false, "bSortable": false, "sWidth":"30px"},
		      {"bSearchable": false, "bSortable": false, "sWidth":"30px"}
			],
			"sAjaxSource" : "<?= base_url('user/get_datatable') ?>",
			"autoWidth" : false,
			"responsive" : true,
		})
	})
</script>