<div class="row">
    <div class="col-md-4">
        <form action="<?= base_url("admin/home/city_status"); ?>" method="post">
            <?= csrf(); ?>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><?= lang('enable_city_features'); ?></label>
                        <select name="is_city_delivery" class="form-control" onchange="this.form.submit();">
                            <option value="1" <?= isset(st()->is_city_delivery) && st()->is_city_delivery == 1 ? "selected" : ""; ?>><?= __('enable'); ?></option>
                            <option value="0" <?= isset(st()->is_city_delivery) && st()->is_city_delivery == 0 ? "selected" : ""; ?>><?= __('disable'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (isset(st()->is_city_delivery) && st()->is_city_delivery == 1): ?>
    <div class="row mt-50">
        <div class="col-md-8">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-header space-between">
                    <h4><?= lang('cities'); ?></h4>
                    <div class="right">
                        <a href="#addNew" class="btn btn-secondary" data-toggle="modal"><i class="fa fa-plus"></i> <?= lang('add_new') ?></a>
                        <a href="#lnModal" data-toggle="modal" class="btn btn-success btn-sm ml-10"><i class="icofont-upload"></i> <?= lang('import'); ?> </a>
                        <a href="<?= base_url("admin/home/generate_csv_template/"); ?>" class="btn btn-secondary btn-sm"> <i class="icofont-download"></i> <?= lang('template'); ?></a>
                        <a href="<?= base_url("admin/home/fix_city_id_1/"); ?>" class="btn btn-warning btn-sm"> <i class="fa fa-wrench"></i> Corrigir ID 1</a>
                        <a href="<?= base_url("admin/home/limpar_dados_cidades/"); ?>" class="btn btn-info btn-sm" onclick="return confirm('Esta ação irá limpar caracteres estranhos em todos os registros. Deseja continuar?');"> <i class="fa fa-broom"></i> Limpar Dados</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class='table-responsive'>
                        <table class='table table-bordered table-striped' id="cities_data_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?= lang('city_name'); ?></th>
                                    <th><?= lang('state'); ?></th>
                                    <th><?= lang('action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dados serão carregados via Ajax -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Modal genérico para edição -->
<div id="updateModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url("admin/home/add_city") ?>" method="post" class="form-submit">
                <?= csrf(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><?= lang('city_name'); ?></label>
                        <input type="text" name="city_name" id="edit_city_name" class="form-control" value="">
                    </div>

                    <div class="form-group">
                        <label for=""><?= lang('state'); ?></label>
                        <input type="text" name="state" id="edit_state" class="form-control" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="edit_id" value="0">
                    <div class="pull-left">
                        <a href="javascript:;" data-dismiss="modal" class="btn btn-default"><?= lang('cancel'); ?></a>
                    </div>
                    <button type="submit" class="btn btn-secondary "><?= lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="addNew" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url("admin/home/add_city") ?>" method="post" class="form-submit">
                <?= csrf(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for=""><?= lang('city_name'); ?></label>
                        <input type="text" name="city_name" class="form-control" value="">
                    </div>

                    <div class="form-group">
                        <label for=""><?= lang('state'); ?></label>
                        <input type="text" name="state" class="form-control" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-left">
                        <a href="javascript:;" data-dismiss="modal" class="btn btn-default"><?= lang('cancel'); ?></a>
                    </div>
                    <button type="submit" class="btn btn-secondary "><?= lang('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($cityList as  $key => $city) : ?>
    <div id="update_<?= $city['id'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?= base_url("admin/home/add_city") ?>" method="post" class="form-submit">
                    <?= csrf(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for=""><?= lang('city_name'); ?></label>
                            <input type="text" name="city_name" class="form-control" value="<?= !empty($city["city_name"]) ? $city["city_name"] : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for=""><?= lang('state'); ?></label>
                            <input type="text" name="state" class="form-control" value="<?= !empty($city["state"]) ? $city["state"] : '' ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= !empty($city["id"]) ? $city["id"] : 0 ?>">
                        <div class="pull-left">
                            <a href="javascript:;" data-dismiss="modal" class="btn btn-default"><?= lang('cancel'); ?></a>
                        </div>
                        <button type="submit" class="btn btn-secondary "><?= lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal para importação de CSV -->
<div id="lnModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url("admin/home/import_city_cvs"); ?>" method="post" class="form-submit" enctype="multipart/form-data">
                <?= csrf(); ?>
                <div class="modal-header">
                    <h4 class="modal-title"><?= lang('import_csv'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><?= lang('select_csv_file'); ?></label>
                        <input type="file" name="csv" class="form-control" accept=".csv" required>
                        <p class="text-muted mt-2">
                            <small>* <?= lang('csv_format'); ?>: city_name, state</small><br>
                            <small>* <?= lang('first_row_header'); ?></small><br>
                            <small>* <?= lang('max_size'); ?>: 2MB</small>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-left">
                        <a href="javascript:;" class="btn btn-default" data-dismiss="modal"><?= lang('cancel'); ?></a>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= lang('import'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Inicializa apenas se o elemento existir na página
    if ($.fn.DataTable.isDataTable('#cities_data_table')) {
        // Destruir a instância anterior
        $('#cities_data_table').DataTable().destroy();
    }
    
    // Primeiro, limpar manualmente os caracteres estranhos nos cabeçalhos
    $('#cities_data_table th').each(function() {
        const headerText = $(this).text().replace(/a-¾|a–³⁄₄|a–|a-|\u00a0|\u2013|\u00be|\u2084|\u2044|\u2154/g, '').trim();
        $(this).empty().text(headerText);
    });
    
    var citiesTable = $('#cities_data_table').DataTable({
        'processing': true,
        'serverSide': true,
        'ajax': {
            'url': '<?= base_url("admin/home/get_cities_ajax") ?>',
            'type': 'GET',
            'dataSrc': function(json) {
                // Verificar se há dados antes de retornar
                return json.data || [];
            },
            'error': function(xhr, error, thrown) {
                console.error('Erro na requisição AJAX:', error, thrown);
            }
        },
        'order': [[1, 'asc']],
        'pageLength': 25,
        'lengthMenu': [[10, 25, 50, 100], [10, 25, 50, 100]],
        'language': {
            'lengthMenu': '<?= lang("show") ?> _MENU_ <?= lang("entries") ?>',
            'search': '<?= lang("search") ?>',
            'zeroRecords': '<?= lang("no_data_found") ?>',
            'info': '<?= lang("showing") ?> _START_ <?= lang("to") ?> _END_ <?= lang("of") ?> _TOTAL_ <?= lang("entries") ?>',
            'infoEmpty': '<?= lang("showing") ?> 0 <?= lang("to") ?> 0 <?= lang("of") ?> 0 <?= lang("entries") ?>',
            'paginate': {
                'first': '<?= lang("first") ?>',
                'last': '<?= lang("last") ?>',
                'next': '<?= lang("next") ?>',
                'previous': '<?= lang("previous") ?>'
            }
        },
        'columnDefs': [{
            'targets': 3, // coluna de ações
            'orderable': false // não permite ordenação
        }],
        'drawCallback': function() {
            // Executado cada vez que a tabela é redesenhada
            $('.a-¾, .a–³⁄₄, span[class*="a-"], span[class*="a–"]').remove();
            
            // Adicionar evento aos botões de edição
            $('a.btn-info').on('click', function() {
                var id = $(this).data('id');
                if (id) {
                    editCity(id);
                    return false;
                }
            });
        },
        'initComplete': function() {
            // Remove caracteres estranhos após inicialização completa
            setTimeout(function() {
                $('.a-¾, .a–³⁄₄, span[class*="a-"], span[class*="a–"]').remove();
            }, 100);
        }
    });
    
    // Função para carregar os dados da cidade para edição
    window.editCity = function(id) {
        $.ajax({
            url: '<?= base_url("admin/home/get_city_by_id/") ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var city = response.data;
                    $('#edit_id').val(city.id);
                    $('#edit_city_name').val(city.city_name);
                    $('#edit_state').val(city.state);
                    $('#updateModal').modal('show');
                } else {
                    alert('<?= lang("error_occurred") ?>');
                }
            },
            error: function() {
                alert('<?= lang("error_occurred") ?>');
            }
        });
    };

    // Limpar input quando o modal de adicionar é aberto
    $('#addNew').on('show.bs.modal', function() {
        $(this).find('input[type="text"]').val('');
    });
});
</script>