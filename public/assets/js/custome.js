$(document).ready(function() {

    $(".confirmDelete").click(function() {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");

        Swal.fire({
            title: 'Apakah Kamu Yakin ?',
            text: "Anda tidak akan dapat mengembalikan ini !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Terhapus !',
                'Berhasil Di Hapus',
                'success'
              )
              window.location.href="/admin/delete-"+record+"/"+recordid;
            }
          });
    });
});
