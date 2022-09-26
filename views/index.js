$(document).ready(function () {
  /**
   * Al dar click llama la función query()
   */
  $("#getDatos").click(() => {
    /**
     * Muestra un mensaje de espera en pantalla
     */
    swal({
      title: "Cargando...",
      text: "Espere unos segundos!",
      icon: "warning",
      timer: 3000,
      showConfirmButton: false,
    });

    query();
  });
  /**
   * Realixa petición para obtener total de contactos.
   */
  $("#getTotal").click(() => {
    $.get("controllers/pruebaController.php?op=total", function (dataT) {
      dataT = JSON.parse(dataT);
      let total = dataT.data[0].count;
      $("#totalC").text(`Total de contactos: ${total}`);
    });
  });

  /**
   * Realiza la petición query y llena la tabla con los datos recibidos
   */
  function query() {
    $.get("controllers/pruebaController.php?op=query", function (data) {
      data = JSON.parse(data);

      tablaDatos = $("#tablaQuery").DataTable({
        destroy: true,
        data: data.data,
        columns: [
          { data: "id" },
          { data: "contact_no" },
          { data: "lastname" },
          { data: "createdtime" },
        ],
        language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningún dato disponible en esta tabla",
          sInfo: "Mostrando un total de _TOTAL_ registros",
          sInfoEmpty: "Mostrando un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sInfoPostFix: "",
          sSearch: "Buscar:",
          sUrl: "",
          sInfoThousands: ",",
          sLoadingRecords: "Cargando...",
          oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior",
          },
        },
      });
    });
  }
});
