<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar sekolah
      </div>
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-bordered table-striped table-sm" id="appTable" style="min-width: 520px">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama sekolah</th>
              <th>Pantau</th>
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
      "ajax"  : '<?= base_url('sekolah/cctv_data'); ?>',
      "order" : [[2, 'asc' ]],
      "responsive": true,
      "columns": [
        {
          "data"    : null,
          "width"   : "50px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data"    : "sekolah" },
        { "data"    : "aksi"}
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