(function () {
    $("#history-table").DataTable({
        paging: true,
        lengthChange: true,
        searching: false,
        ordering: false,
        info: true,
        autoWidth: false,
        order: [1, 2, 3, 4],
        language: {
            decimal: ".",
            thousands: ",",
            sLengthMenu: "_MENU_ 件/ページ ",
            sZeroRecords: "データはありません。",
            sInfoPostFix: "",
            sSearch: "検索:",
            sUrl: "",
            oPaginate: {
                sFirst: "<<",
                sPrevious: "<",
                sNext: ">",
                sLast: ">>",
            },
        },
        pageLength: 10,
        sDom: 'rt<"pagination"ipl>',
    });
})();
