<div class="filterAreas">
    <form action="" method="get">
        <div class="filterButtonGroup flex-1">
            <div class="form-group">
                <div class="ci-input-group">
                    <input type="text" name="daterange" class="form-control" value="<?= !empty($this->input->get('daterange',true)) ? $this->input->get('daterange',true) : full_date(today()); ?>">
                    <div class="input-group btn btn-default">
                        <i class="fa fa-calendar"></i>
                    </div>
                </div>
            </div>
            <?php $reportType = ["xReport", "summaryReport", "expenseReport"]; ?>
            <div class="form-group">
                <select name="q" class="form-control" id="q" onchange="this.form.submit()">
                    <?php foreach ($reportType as  $key => $r) : ?>
                        <option value="<?= $r; ?>" <?= isset($_GET['q']) && $_GET['q'] == $r ? "selected" : ""; ?>>
                            <?= lang($r); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-secondary btn-lg " type="submit"><i class="fa fa-filter"></i></button>
            </div>

        </div>
    </form>
    <?php include VIEWPATH . 'backend/common/exportBtn.php'; ?>
</div>
<div class="row mt-20">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?= lang('report'); ?></h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="zReportHeader">
                                <td>
                                    <h4><?= isset($_GET['q'])?lang($_GET['q']): ''; ?></h4>
                                    <p><?= lang('date'); ?> : <?= !empty($this->input->get('daterange',true)) ? $this->input->get('daterange',true) : full_date(today()); ?></p>
                                </td>
                            </tr>
                        </thead>
                    </table>
                    <?php if (isset($_GET) && !empty($_GET)) : ?>
                        <?php $type = strtolower($_GET['q']); ?>
                        <?php include "layouts/{$type}.php"; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>