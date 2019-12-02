 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar user 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah user</button>
      </div>
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <input type="hidden" id="base_url" value="<?= base_url('user') ?>">
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-bordered table-striped table-sm" id="appTable" style="min-width: 520px">
          <thead>
            <tr>
              <th>#</th>
              <th>Login</th>
              <th>Nama</th>
              <th>Status</th>
              <th>Peran</th>
              <th>Sekolah</th>
              <th>Aksi</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        </div>
      </div>
      <div class="card-footer">
        <button type="button" id="btn-edit-hapus" class="btn btn-primary btn-sm">Hapus</button>
        <button type="button" id="btn-edit-pilih" class="btn btn-danger btn-sm pull-right">Pilih Semua</button>
      </div>
    </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus user</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <strong>Peringatan</strong>
        Data user yang dipilih akan dihapus beserta dengan data yang berelasi dengan tabel user.
        <br /><br />
        Apakah anda yakin untuk menghapus data user ?
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-hapus" class="btn btn-danger btn-sm">Hapus</button>
        <a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Tutup</a>
      </div>
    </div>
  </div>
</div>

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
              <option value="0">TIDAK AKTIF</option>
            </select>
          </div>
          <div class="form-group">
            <label>Peran</label>
            <select class="form-control" name="role_id" id="role_id">
              <option value="2">Piket</option>
              <option value="3">Kepsek</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="tambah-simpan" class="btn btn-success">Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="modal fade" id="modal-edit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-edit" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah user</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan-edit"></div>
          <div class="form-group">
            <label>Sekolah</label>
            <input type="hidden" id="e-id" name="id">
            <select class="form-control" name="sekolah_id" id="e-sekolah_id"> 
              <?php foreach($sekolah as $s): ?>
                <option value="<?= $s->id ?>"><?= $s->nama_sekolah ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>User login</label>
            <input type="text" class="form-control" id="e-username" name="username" placeholder="Username">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" id="e-name" name="name" placeholder="Nama">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="is_active" id="e-is_active">
              <option value="1">AKTIF</option>
              <option value="0">TIDAK AKTIF</option>
            </select>
          </div>
          <div class="form-group">
            <label>Peran</label>
            <select class="form-control" name="role_id" id="e-role_id">
              <option value="2">Piket</option>
              <option value="3">Kepsek</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="edit-simpan" class="btn btn-success">Ubah</button>
        </div>
      </div>
    </form>
  </div>
</div>


<script>
	function tambah()
	{
	  $('#form-pesan').html('');
	  $('#sekolah_id').val('');
	  $('#username').val('');
	  $('#name').val('');
	  $('#password').val('');
	  $('#modal-tambah').modal('show');
	}

  function edit(id)
  {
    Pace.restart();
    Pace.track(function () {
      $.getJSON('<?= base_url('user/show/') ?>'+id, function(data) {
        if(data.data == 1) {
          $('#e-id').val(data.id)
          $('#e-sekolah_id').val(data.sekolah_id)
          $('#e-username').val(data.username)
          $('#e-name').val(data.name)
          $('#e-is_active').val(data.is_active)
          $('#e-role_id').val(data.role_id)

          $('#form-pesan-edit').html('');
          $('#modal-edit').modal('show');
        }
      })
    })
  }

	$(function(){

		let table = $('#appTable').DataTable( {
      "ajax"  : '<?= base_url('user/data'); ?>',
      "order" : [[2, 'asc' ]],
      "columns": [
        {
          "data"    : null,
          "width"   : "50px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data"    : "username" },
        { "data"    : "name" },
        { "data"    : "status" },
        { "data"    : "role" },
        { "data"    : "sekolah" },
        { "data"    : "aksi",
          "orderable": false,
          "width"   : "50px",
        },
        { "data"    : "check",
          "orderable": false,
          "width"   : "10px", 
        }
      ]
    });

    table.on( 'order.dt search.dt', function() {
       table.column(0, { search : 'applied', order:'applied'}).nodes().
        each( function(cell, i) {
          cell.innerHTML = i+1;
        });
    }).draw();   
	})
</script>