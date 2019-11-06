<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar cctv 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah cctv</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('cctv') ?>">
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Kelas</th>
              <th>Link</th>
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="modal-tambah" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-tambah" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah CCTV</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Kelas</label>
            <select class="form-control" name="kelas_id" id="kelas_id">
              <?php foreach($kelas as $k): ?>
              <option value="<?= $k->id ?>"><?= $k->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Link</label>
            <input type="text" class="form-control" id="link" name="link" placeholder="Link cctv(http://cctvecam.com)">
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

<!-- Modal edit Data -->
<div class="modal fade" id="modal-edit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-edit" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit cctv</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan-edit"></div>
          <div class="form-group">
            <label>Kelas</label>
            <input type="hidden" id="e-id" name="id">
            <select class="form-control" name="kelas_id" id="e-kelas_id">
              <?php foreach($kelas as $k): ?>
              <option value="<?= $k->id ?>"><?= $k->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Link</label>
            <input type="text" class="form-control" id="e-link" name="link" placeholder="Link cctv(http://cctvecam.com)">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="edit-simpan" class="btn btn-success">Simpan</button>
        </div>
    </div>
    </form>
  </div>
</div>
<div class="modal fade" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus cctv</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <strong>Peringatan</strong>
        Data cctv yang dipilih akan dihapus beserta dengan data yang berelasi dengan tabel cctv.
        <br /><br />
        Apakah anda yakin untuk menghapus data cctv ?
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-hapus" class="btn btn-danger btn-sm">Hapus</button>
        <a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Tutup</a>
      </div>
    </div>
  </div>
</div>
<script>
  function show()
  {
    console.log('oke');
  }
  function tambah()
  {
    $('#link').val('');

    $('#form-pesan').html('');
    $('#modal-tambah').modal('show');
  }

  function edit(id)
  {
    showLoading();
    $.getJSON('<?= base_url('cctv/show/') ?>'+id, function(data) {
      if(data.data == 1) {
        $('#e-id').val(data.id)
        $('#e-kelas_id').val(data.kelas_id)
        $('#e-link').val(data.link)

        $('#form-pesan-edit').html('');
        $('#modal-edit').modal('show')
      }
      hideLoading()
    })
  }

  $(function() {
    let table = $('#appTable').DataTable( {
      "ajax"  : '<?= base_url('cctv/data'); ?>',
      "order" : [[2, 'asc' ]],
      "columns": [
        {
          "data"    : null,
          "width"   : "50px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data"    : "kelas" },
        { "data"    : "link" },
        { "data"    : "aksi",
          "orderable": false,
          "width"   : "50px",
        },
        { "data"    : "check",
          "orderable": false,
          "width"   : "10px", 
        }
      ]
    })
    table.on( 'order.dt search.dt', function() {
       table.column(0, { search : 'applied', order:'applied'}).nodes().
        each( function(cell, i) {
          cell.innerHTML = i+1;
        });
    }).draw();  
  })
</script>