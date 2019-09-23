<div class="row">
  <div class="col-lg-12">
     <?= $this->session->flashdata('message'); ?>
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Edit
        <button class="btn btn-success btn-sm pull-right" onclick="tambah()">Tambah jadwal</button>
      </div>
      <input type="hidden" id="base_url" value="<?= base_url('jadwal') ?>">
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table width="20%">
          <tr>
            <td>Nama lengkap</td> <td>:</td>
            <td><?= $guru->nama ?></td>
          </tr>
          <tr>
            <td>Nip</td> <td>:</td>
            <td><?= $guru->nip ?></td>
          </tr>
        </table>
        <br>
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Hari</th>
              <th>Jam</th>
              <th>Kelas</th>
              <th>Aksi</th>
              <th>Pilih</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      </form>
      <div class="card-footer">
        <a href="<?= base_url('jadwal') ?>" class="btn btn-light btn-sm">Kembali</a>
        <button type="button" id="btn-edit-hapus" class="btn btn-primary btn-sm">Hapus</button>
        <button type="button" id="btn-edit-pilih" class="btn btn-danger btn-sm pull-right">Pilih Semua</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="modal-tambah" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="form-tambah">
      <input type="hidden" name="guru_id" value="<?= $this->uri->segment(3) ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah jadwal</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Hari</label>
            <select name="hari_id" class="form-control">
              <?php foreach($hari as $h): ?>
                <option value="<?= $h->id ?>"><?= $h->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Interval</label>
            <select name="seling_id" class="form-control">
              <?php foreach($interval as $i): ?>
                <option value="<?= $i->id ?>"><?= $i->dari ?> - <?= $i->sampai ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Kelas</label>
            <select name="kelas_id" class="form-control">
              <?php foreach($kelas as $i): ?>
                <option value="<?= $i->id ?>"><?= $i->nama ?></option>
              <?php endforeach; ?>
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

<div class="modal fade" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus jadwal</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <strong>Peringatan</strong>
        Jadwal yang dipilih akan dihapus beserta dengan data yang berelasi dengannya.
        <br /><br />
        Apakah anda yakin untuk menghapus jadwal ?
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-hapus" class="btn btn-danger btn-sm">Hapus</button>
        <a href="#" class="btn btn-primary btn-sm" data-dismiss="modal">Tutup</a>
      </div>
    </div>
  </div>

<script>
  function tambah()
  { 
    $('#modal-tambah').modal('show')
  }

  $(function() {
    $('#appTable').DataTable({
      "serverSide": true,
      "processing" : true,
      "ajax"  : '<?= base_url('jadwal/data/'.$this->uri->segment(3)) ?>',
    })
  })
</script>