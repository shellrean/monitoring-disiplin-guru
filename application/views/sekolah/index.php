<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar sekolah 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah sekolah</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('sekolah') ?>">
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-bordered table-striped table-sm" id="appTable" style="min-width: 520px">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Sekolah</th>
              <th width="65%">Alamat Sekolah</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Tambah sekolah</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Nama sekolah</label>
            <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" placeholder="Nama sekolah">
          </div>
          <div class="form-group">
            <label>Alamat sekolah</label>
            <textarea class="form-control" id="alamat_sekolah" name="alamat_sekolah" placeholder="Alamat sekolah"></textarea>
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

<!-- Modal Edit Data -->
<div class="modal fade" id="modal-edit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-edit" >
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit sekolah</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan-edit"></div>
          <div class="form-group">
            <input type="hidden" name="id" id="edit-id">
            <label>Nama sekolah</label>
            <input type="text" class="form-control" id="edit-nama_sekolah" name="nama_sekolah" placeholder="Nama sekolah">
          </div>
          <div class="form-group">
            <label>Alamat sekolah</label>
            <textarea class="form-control" id="edit-alamat_sekolah" name="alamat_sekolah" placeholder="Alamat sekolah"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
          <button type="submit" id="edit-simpan" class="btn btn-success">Simpan</button>
        </div>
    </div>
    </form>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus sekolah</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <strong>Peringatan</strong>
        Data sekolah yang dipilih akan dihapus beserta dengan data yang berelasi dengan sekolah.
        <br /><br />
        Apakah anda yakin untuk menghapus data Sekolah ?
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-hapus" class="btn btn-danger btn-sm">Hapus</button>
        <a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Tutup</a>
      </div>
    </div>
  </div>
</div>


<script>
  function tambah()
  {
    $('#form-pesan').html('');
    $('#nama_sekolah').val('');
    $('#alamat_sekolah').val('');

    $('#modal-tambah').modal('show');
  }

  function edit(id)
  {
    Pace.restart();
    Pace.track(function () {
      $.getJSON('<?= base_url('sekolah/show/') ?>'+id, function(data) {
        if(data.data == 1) {
          $('#edit-id').val(data.id);
          $('#edit-nama_sekolah').val(data.nama_sekolah);
          $('#edit-alamat_sekolah').val(data.alamat_sekolah);

          $("#modal-edit").modal("show");
        }
        hideLoading();
      })
    })
  }

  $(function(){
    $('#appTable').DataTable({
      "paging" : true,
      "iDisplayLength":10,
      "bProcessing": true,
      "bServerSide": true, 
      "searching": true,
      "aoColumns": [
      {"bSearchable": false, "bSortable": false, "sWidth":"20px"},
      {"bSearchable": false, "bSortable": false},
      {"bSearchable": false, "bSortable": false},
      {"bSearchable": false, "bSortable": false, "sWidth":"30px"},
      {"bSearchable": false, "bSortable": false, "sWidth":"30px"}],
      "sAjaxSource": "<?= site_url().'/sekolah' ?>/get_datatable/",
      "autoWidth": false,
      "responsive": true,
    })
  })
</script>