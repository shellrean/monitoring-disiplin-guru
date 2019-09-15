<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar sekolah 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah sekolah</button>
      </div>
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="table-sekolah">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Sekolah</th>
              <th>Alamat Sekolah</th>
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
            <h5 class="modal-title" id="exampleModalLabel">Edit sekolah</h5>
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
          <button type="button" id="edit-simpan" class="btn btn-success">Simpan</button>
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
  function refresh_table() {
    $('#table-sekolah').dataTable().fnReloadAjax();
  }

  function tambah()
  {
    $('#form-pesan').html('');
    $('#nama_sekolah').val('');
    $('#alamat_sekolah').val('');

    $('#modal-tambah').modal('show');
  }

  function edit(id)
  {
    $('#modal-proses').modal('show');
    $.getJSON('<?= base_url('sekolah/get_by_id/') ?>'+id, function(data) {
      if(data.data == 1) {
        $('#edit-id').val(data.id);
        $('#edit-nama_sekolah').val(data.nama_sekolah);
        $('#edit-alamat_sekolah').val(data.alamat_sekolah);

        $("#modal-edit").modal("show");
      }
      hideLoading();
    })
  }

  function hideLoading()
  {
    $('#modal-proses').on('shown.bs.modal', function(e) {
      $('#modal-proses').modal('hide')
    })
  }

  $(function(){
    $('#btn-edit-pilih').click(function(e){
      if($('#check').val() == 0) {
        $(':checkbox').each(function() {
          this.checked = true;
        });
        $('#check').val('1');
      } else {
        $(':checkbox').each(function() {
          this.checked = false;
        });
        $('#check').val('0');
      }
    })

    $('#btn-edit-hapus').click(function() {
      $('#modal-hapus').modal('show')
    })

    $('#btn-hapus').click(function(){
      $('#form-hapus').submit();
    })

    $('#form-hapus').submit(function(e){
      e.preventDefault();
        $("#modal-proses").modal('show');
        $.ajax({
          url:"<?= site_url().'/sekolah' ;?>/hapus_sekolah",
          type:"POST",
          data:$('#form-hapus').serialize(),
          cache: false,
          success:function(respon){
            let obj = $.parseJSON(respon);
            if(obj.status==1){
              refresh_table();
              hideLoading();
              $("#modal-hapus").modal('hide');
              notify_success(obj.pesan);
              $('#check').val('0');
            }else{
              hideLoading();
              $('#modal-hapus').modal('hide');
              notify_error(obj.pesan);
            }
          }
        });
        
      return false;
    });

    $('#form-tambah').submit(function(e){
      e.preventDefault();

      $('#modal-proses').modal('show');
      $.ajax({
        url:"<?= base_url('sekolah/tambah') ?>",
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

    $('#edit-simpan').click(function() {
      $('#form-edit').submit();
    })

    $('#form-edit').submit(function(e) {
      e.preventDefault();
      $('#modal-proses').modal('show');
      $.ajax({
        url: "<?= base_url('sekolah/edit') ?>",
        type: "POST",
        data:$('#form-edit').serialize(),
        cache: false,
        success(res) {
          let obj = $.parseJSON(res);
          if(obj.status  == 1) {
            refresh_table();
            hideLoading();
            $('#modal-edit').modal('hide');
            notify_success(obj.pesan)
          }
          else {
            hideLoading();
            $('#form-pesan-edit').html(pesan_err(obj.pesan))
          }
        }
      })

      return false;
    })
    $('#table-sekolah').DataTable({
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