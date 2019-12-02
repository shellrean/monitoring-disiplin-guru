<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
        <?php if(user()->role_id == 1): ?>
        <a href="<?= base_url('sekolah/cctv') ?>" class="btn btn-warning btn-sm">Kembali</a>
        <?php endif; ?>
      </div>
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-bordered" id="tab_cctv" >
          <thead>
            <tr>
              <td>Nama cctv</td>
              <td>Username</td> 
              <td>Password</td>
              <td>Link browser</td>
              <td>Link android</td>
            </tr>
          </thead>
          <tbody>
            <?php foreach($kelas as $k): ?> 
            <tr>
              <td><?= $k->nama_cctv; ?></td>
              <td><?= $k->username; ?></td>
              <td><?= $k->password; ?></td>
              <td><a target="_blank" href="<?= $k->link_desktop; ?>">Lihat</a></td>
              <td><a target="_blank" rel="alternate" href="<?= $k->link_mobile; ?>">Lihat</a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div> 
</div>
<script>
