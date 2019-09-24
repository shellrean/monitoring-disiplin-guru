<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar interval 
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah hari masuk</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('jadwal') ?>">
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Hari</th>
              <th>Interval</th>
              <th>Aksi</th>
              <th></th>
            </tr> 
          </thead>
          <tbody>
            <?php $no=1; foreach($datas as $d): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $d->nama ?></td>
              <?php 
                $data = $this->db->get_where('seling',['hari_id' => $d->id,'sekolah_id' => user()->sekolah_id])->result();
              ?>
              <td>
                <?php foreach($data as $ds): ?>
                  <span class="btn btn-primary btn-sm"><?= $ds->dari ?> - <?= $ds->sampai ?></span>
                <?php endforeach; ?>
              </td>
              <td>
                <a href="" class="btn btn-sm btn-success">Edit</a>
              </td>
              <td>
                <input type="checkbox" name="">
              </td>
            </tr>
            <?php endforeach; ?>
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
    <form method="post" action="<?= base_url('interval/store') ?>" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah interval</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Hari</label>
            <select class="form-control" name="hari_id">
              <?php foreach($datas as $d): ?>
                <option value="<?= $d->id ?>"><?= $d->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Dari</label>
            <input type="time" name="dari" class="form-control">
          </div>
          <div class="form-group">
            <label>Sampai</label>
            <input type="time" name="sampai" class="form-control">
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

<script>
  function tambah()
  {
    $('#form-pesan').html('');
    $('#modal-tambah').modal('show')
  }
</script>