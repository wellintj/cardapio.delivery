<script src="<?= asset_url(); ?>assets/frontend/html2pdf/pdf.main.js"> </script>
<style>
    body {
        background-color: #e9ecef
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        border: 1px solid rgba(0, 0, 0, .05);
        background-color: #fff;
        background-clip: border-box;
        border-radius: 20px;
        padding-top: 10px;
        padding: 10px;
    }

    #printArea {
        padding: 20px;
    }

    .mb-5 {
        margin-bottom: 5px !important;
    }

    .text-danger-m1 {
        color: #dd4949 !important;
    }

    .text-primary-m1 {
        color: #4087d4 !important;
    }

    .priceTag {
        color: #777;
    }

    .extars ul {
        padding-left: 0;
    }

    .btn {
        font-size: .875rem;
        position: relative;
        transition: all .15s ease;
        letter-spacing: .025em;
        text-transform: none;
        will-change: transform;
    }

    table.customTable.invoiceTable th {
        background-color: #5e72e4 !important;
        color: #fff !important;
    }

    td p {
        text-transform: capitalize;
    }

    .orderQr img {
        height: 100px;
        width: 100px;
        margin: 0 auto;
        text-align: center;
        margin-top: 5px;
        margin-left: 28px;
    }

    .orderQr {
        width: 100%;
        margin: 0 auto;
        text-align: center;
        margin-top: -37px;
    }

    .btn.bg-white {
        color: var(--color);
    }

    @media print {
        a[href]:after {
            content: none !important;
        }

        .printLeft {
            width: 100%;
        }

        .orderQr {
            float: right;
        }

    }


    @page {
        size: auto;
        margin: 0;
    }
</style>
<?php $shop_id = $order_info['shop_id']; ?>
<div class="container">
    <div class="page-content">
        <div class="page-header text-blue-d2">
            <h1 class="display-4"></h1>
            <div class="page-tools">

                <div class="action-buttons no-print">
                    <?php if (file_exists(APPPATH . 'controllers/admin/Pos.php')) : ?>
                        <a href="javascript:;" id="pos-print" class="btn bg-white btn-light mx-1px text-95" data-title="Print">
                            <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                            <?= !empty(lang('pos_print')) ? lang('pos_print') : "POS Print"; ?>
                        </a>
                    <?php endif; ?>

                    <a href="javascript:;" id="printBtn" class="btn bg-white btn-light mx-1px text-95" data-title="Print">
                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                        <?= !empty(lang('print')) ? lang('print') : "Print"; ?>
                    </a>
                    <?php if (check() == 1) : ?>
                        <a id="exportBtn" href="javascript:;" class="btn bg-white btn-light mx-1px text-95" data-title="PDF">
                            <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                            <?= !empty(lang('export')) ? lang('export') : "Export"; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card p-sm-0">
            <div id="printArea">
                <?php include "invoice_thumb.php"; ?>
            </div>
        </div>
    </div>
</div>