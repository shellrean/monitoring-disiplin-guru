<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
       <a href="<?= base_url('panel/guru'); ?>" class="btn btn-success btn-sm">Kembali</a>
      </div>
      <input type="hidden" id="sekolah_id" value="<?= $id_sekolah; ?>">
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>#</th>
              <th>NIP</th>
              <th>Nama</th>
            </tr>
          </thead> 
          <tbody>
          </tbody>
        </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    let table = $('#appTable').DataTable( {
      "ajax"  : '<?= base_url('guru/list/'); ?>' + $('#sekolah_id').val(),
      "order" : [[2, 'asc' ]],
      "columns": [
        {
          "data"    : null,
          "width"   : "50px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data"    : "nip" },
        { "data"    : "nama" },
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