<script>
    $(document).ready(function() {
        // Print function
        window.printModalContent = function() {
            var printWindow = window.open("", "", "height=600,width=800");
            var printContent = document.querySelector(
                "#detailModal .modal-body"
            ).innerHTML;
            printWindow.document.write("<html><head><title>Print Modal</title>");
            // Add the necessary styles for printing
            printWindow.document.write(
                '<link rel="stylesheet" href="{{ asset('template/css/style.css') }}">'
            );
            printWindow.document.write(
                "<style>@media print { .no-print { display: none !important; } }</style>"
            );
            printWindow.document.write("</head><body>");
            // Exclude the print button
            printWindow.document.write(
                '<div class="no-print">' +
                document.querySelector("#detailModal .d-flex").outerHTML +
                "</div>"
            );
            printWindow.document.write("<h1>Detail Pembayaran</h1>");
            printWindow.document.write(printContent);
            printWindow.document.write("</body></html>");
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        };
    });
</script>
