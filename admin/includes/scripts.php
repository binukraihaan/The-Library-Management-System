<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Moment JS -->
<script src="../bower_components/moment/moment.js"></script>
<!-- DataTables -->

<!--
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.9/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.9/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script> -->

<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<!-- daterangepicker -->
<script src="../bower_components/moment/min/moment.min.js"></script>
<script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Slimscroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
  $(function() {
    /** add active class and stay opened when selected */
    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
      return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.treeview-menu a').filter(function() {
      return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

  });
</script>
<!-- Data Table Initialize -->
<script>
  $(function() {
    // $('#example1').DataTable({
    //   responsive: true
    // }
    // )

    new DataTable('#example1', {
      responsive: true,
      layout: {
        topStart: {
          // buttons: ['print', 'excelHtml5', 'csvHtml5', 'pdfHtml5', 'colvis']
          buttons: [{
              extend: 'print',
              exportOptions: {
                columns: ['0, 2, 3, 4']
              }
            },
            {
              extend: 'excelHtml5',
              exportOptions: {
                columns: ['0, 2, 3, 4']
              }
            },
            {
              extend: 'csvHtml5',
              exportOptions: {
                columns: ['0, 2, 3, 4']
              }
            },
            {
              extend: 'pdfHtml5',
              exportOptions: {
                columns: ['0, 2, 3, 4']
              }
            },
            'colvis'
          ]
        }
      }
    });

    new DataTable('#example2', {
      'paging': true,
      'lengthChange': false,
      'searching': false,
      'ordering': true,
      'info': true,
      'autoWidth': false
    })

    new DataTable('#example3', {
      'paging': true,
      'lengthChange': false,
      'searching': true,
      'ordering': true,
      'info': true,
      'autoWidth': false,
      layout: {
        topStart: {
          buttons: ['print', 'excelHtml5', 'csvHtml5', 'pdfHtml5', 'colvis']
        }
      }
    })

    new DataTable('#course_tb', {
      responsive: true,
      layout: {
        topStart: {
          // buttons: ['print', 'excelHtml5', 'csvHtml5', 'pdfHtml5', 'colvis']
          buttons: [{
              extend: 'print',
              exportOptions: {
                columns: ['0']
              }
            },
            {
              extend: 'excelHtml5',
              exportOptions: {
                columns: ['0']
              }
            },
            {
              extend: 'csvHtml5',
              exportOptions: {
                columns: ['0']
              }
            },
            {
              extend: 'pdfHtml5',
              exportOptions: {
                columns: ['0']
              }
            },
            'colvis'
          ]
        }
      }
    });

  })
</script>
<!-- Date and Timepicker -->
<script>
  //Date picker
  $('#datepicker_add').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })
  $('#datepicker_edit').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd'
  })

  var loader = document.getElementById('preloader');
  window.addEventListener('load', function() {
    loader.style.display = 'none';
  })

  function homebtn() {
    window.location = '../index.php';
  }

  function routetobarcode() {
    window.location = 'barcode_generator.php';
  }

  function generateBarcode() {
    var input = document.getElementById("input").value;
    var barcode = document.getElementById("barcode");
    if (input == '') {
      // alert("<<!-- Provide  the data first --!>> ");
      Swal.fire({
        title: "ERROR",
        text: "Find a user..",
        icon: "error"
      });
      return false;
    } else {
      JsBarcode(barcode, input);
      barcode.style.display = "inline";

    }
  }

  function downloadBarcode(e) {
    const canvas = document.createElement("canvas");
    const svg = document.getElementById("barcode");
    const base64doc = btoa(unescape(encodeURIComponent(svg.outerHTML)));
    const w = parseInt(svg.getAttribute('width'));
    const h = parseInt(svg.getAttribute('height'));
    const img_to_download = document.createElement('img');
    img_to_download.src = 'data:image/svg+xml;base64,' + base64doc;
    console.log(w, h);
    img_to_download.onload = function() {
      console.log('img loaded');
      canvas.setAttribute('width', w);
      canvas.setAttribute('height', h);
      const context = canvas.getContext("2d");
      //context.clearRect(0, 0, w, h);
      context.drawImage(img_to_download, 0, 0, w, h);
      const dataURL = canvas.toDataURL('image/png');
      if (window.navigator.msSaveBlob) {
        window.navigator.msSaveBlob(canvas.msToBlob(), "download.png");
        e.preventDefault();
      } else {
        const a = document.createElement('a');
        const my_evt = new MouseEvent('click');
        a.download = 'download.png';
        a.href = dataURL;
        a.dispatchEvent(my_evt);
      }
      //canvas.parentNode.removeChild(canvas);
    }
  }

  

  $(document).ready(function() {
    $('#input').select2(); // Initialize Select2 on your select element
  });

  //   $(document).ready(function() {
  //   $('#input').selectpicker(); // Initialize Bootstrap Select on your select element
  // });
</script>