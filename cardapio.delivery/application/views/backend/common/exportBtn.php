<div class="filterButtons">
    <div class="btn-group ci-dropdown mb-15">
        <a href="javascript:;" class="dropdown-btn dropdown-toggle btn  bg-purple-soft-active btn-sm btn-flat" data-toggle="dropdown" aria-expanded="false">
            <span class="drop_text"><i class="icofont-upload-alt"></i> <?= lang('export'); ?> </span> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu dropdown-ul" role="menu">
            <li class=""><a href="javascript:;" onclick="printDiv('printArea');"><i class="icofont-print"></i> <?= lang('print'); ?></a></li>
            <li class=""><a href="javascript:;" onclick="exportPdf('printArea');"><i class="fa fa-file-pdf-o"></i> <?= lang('pdf'); ?></a></li>
            <li class=""><a href="javascript:;" onclick="copy('printArea');"><i class="fa fa-clone"></i> <?= lang('copy'); ?></a></li>
            <li class=""><a href="javascript:;" onclick="csv('printArea');"><i class="fa fa-file-text-o"></i> <?= lang('csv'); ?></a></li>
            <li class=""><a href="javascript:;" onclick="excel('printArea');"><i class="fa fa-file-excel-o"></i> <?= lang('excel'); ?></a></li>
        </ul>
    </div>
    <!-- printThis -->
    <script type="text/javascript" src="<?= asset_url(); ?>assets/frontend/html2pdf/html2pdf.bundle.js"></script>
     <script src="<?= asset_url("public/plugins/xlsx.main.js")?>"></script>
</div>
<script>
    let orderId = `<?= random_string('numeric', 4) ?>`;

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function exportPdf(areaArea) {
        var element = document.getElementById(areaArea);
        var opt = {
            // margin:       1,
            filename: 'report_' + orderId + '.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        };

        html2pdf().set(opt).from(element).save();
    }


    function copy(divName) {
        var contentText = document.getElementById(divName).innerText;

        // Create a temporary textarea element
        var textarea = document.createElement('textarea');
        textarea.value = contentText;

        // Hide the textarea
        textarea.style.position = 'absolute';
        textarea.style.left = '-9999px';

        // Append the textarea to the body
        document.body.appendChild(textarea);

        // Select and copy the content
        textarea.select();
        document.execCommand('copy');

        // Remove the textarea from the DOM
        document.body.removeChild(textarea);

        // Optionally, provide feedback to the user
        alert('Text content copied to clipboard!');

    }

    function csv(divName){
         var contentText = document.getElementById(divName).innerText.trim();

      // Replace newline characters with commas to create CSV format
      var csvContent = contentText.replace(/\n/g, ',');

      // Create a Blob containing the CSV data
      var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

      // Create a link element and set its attributes for downloading
      var link = document.createElement('a');
      link.href = URL.createObjectURL(blob);
      link.download = 'report_'+orderId+'.csv';

      // Append the link to the document
      document.body.appendChild(link);

      // Trigger a click on the link to initiate the download
      link.click();

      // Remove the link from the document
      document.body.removeChild(link);
    }


    function excel(divName){
        let type = 'xlsx';

        var data = document.getElementById(divName);

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'report_'+orderId+'.' + type);
    }
</script>