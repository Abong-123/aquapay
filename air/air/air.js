    $(document).ready(function () {


      uri=window.location.href;
      e=uri.split("=");
      console.log("URI: "+uri+"e[1]:"+e[1]);
      if(e[1]=="user") {
      }
      else {
        $("#pilih_waktu select [name='pilih_waktu']").on("change", function () {
          console.log("dipilih");
        });
      }
    }); 