<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}



if (!function_exists('is_test')) {
    function is_test()
    {
        $ci = &get_instance();
        $settings = settings();
        if (isset($settings['environment']) && $settings['environment'] == 'demo') :
            $ci->session->set_flashdata('error', 'Sorry Not available in demo');
            redirect($_SERVER['HTTP_REFERER']);
            exit();
        else :
        endif;
    }
}

if (!function_exists('is_demo')) {
    function is_demo()
    {
        $ci = &get_instance();
        $settings = settings();
        if (isset($settings['environment']) && $settings['environment'] == 'demo') :
            return 1;
        else :
            return 0;
        endif;
    }
}


if (!function_exists('is_login')) {

    function is_login()
    {
        $ci = get_instance();
        if ($ci->session->userdata('is_login') != true) {
            $ci->session->sess_destroy();
            redirect(base_url('login'));
        } elseif (empty(get_user_info())) {
            $ci->session->sess_destroy();
            redirect(base_url('login'));
        }
    }
}

if (!function_exists('count_days')) {
    function count_days($start, $end)
    {
        $datetime1 = date_create($start);
        $datetime2 = date_create($end);
        $interval = date_diff($datetime1, $datetime2);
        $date_differ =  $interval->format('%a');


        return $date_differ;
    }
}




if (!function_exists('check_info')) {
    function check_info()
    {

        $ci = &get_instance();
        $settings = settings();
        if (LICENSE != MY_LICENSE) {
            redirect(base_url());
        }
    }
}


if (!function_exists('check')) {
    function check()
    {

        $ci = &get_instance();
        $settings = settings();
        if (LICENSE == MY_LICENSE) {
            return 1;
        } else {
            return 0;
        }
    }
}



if (!function_exists('str_slug')) {

    function str_slug($string, $separator = '-')
    {
        $ci = get_instance();
        $re = "/(\\s|\\" . $separator . ")+/mu";
        $str = @trim($string);
        $subst = $separator;
        $result = preg_replace($re, $subst, $str);
        return mb_strtolower($result, mb_detect_encoding($result));
    }
}




if (!function_exists('c_date')) {
    function c_time()
    {

        $dt = new DateTime('now', new DateTimezone(time_zone()));
        $date_time = $dt->format('d-m-Y');

        return $date_time;
    }
}
if (!function_exists('today')) {
    function today()
    {

        $dt = new DateTime('now', new DateTimezone(time_zone()));
        $date_time = $dt->format('Y-m-d');

        return $date_time;
    }
}



if (!function_exists('d_time')) {
    function d_time()
    {
        $dt = new DateTime('now', new DateTimezone(time_zone()));
        if ($dt) {
            $date_time = $dt->format('Y-m-d H:i:s');
        } else {
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date_time = $dt->format('Y-m-d H:i:s');
        }
        return $date_time;
    }
}

if (!function_exists('add_year')) {
    function add_year($type, $duration = '', $period = '')
    {
        $current_date = strtotime(d_time());
        if ($type == 'yearly' || $type == 'year') {
            $date = strtotime("+ 1 year", $current_date);
            $date = date('Y-m-d', $date);
            $end_date = $date . " 23:59:59";
        } elseif ($type == 'monthly' || $type == 'month') {
            $date = strtotime("+ 1 month", $current_date);
            $date = date('Y-m-d', $date);
            $end_date = $date . " 23:59:59";
        } elseif ($type == 'trial') {
            $date = strtotime("+ 1 month", $current_date);
            $date = date('Y-m-d', $date);
            $end_date = $date . " 23:59:59";
        } elseif ($type == 'weekly' || $type == 'week') {
            $date = strtotime("+ 7 days", $current_date);
            $date = date('Y-m-d', $date);
            $end_date = $date . " 23:59:59";
        } elseif ($type == 'fifteen') {
            $date = strtotime("+ 15 days", $current_date);
            $date = date('Y-m-d', $date);
            $end_date = $date . " 23:59:59";
        } elseif ($type == 'half_yearly' || $type == 'half_year') {
            $date = strtotime("+ 6 month", $current_date);
            $date = date('Y-m-d', $date);
            $end_date = $date . " 23:59:59";
        } elseif (strtolower($type) == 'custom') {
            $date = strtotime("+ {$duration} {$period}", $current_date);
            $date = date('Y-m-d', $date);
            $end_date = $date . " 23:59:59";
        } else {
            $end_date = '0000-00-00 00:00:00';
        }
        return $end_date;
    }
}



if (!function_exists('add_time')) {
    function add_time($time, $slot)
    {
        $current_date = strtotime(d_time());
        $date = strtotime('+' . ' ' . $time . ' ' . $slot, $current_date);
        $date = date('Y-m-d H:i:s', $date);
        return $date;
    }
}

if (!function_exists('add_date')) {
    //duration = 1,2 and type= days,month,year
    function add_date($duration, $type)
    {
        $current_date = strtotime(d_time());
        $date = strtotime("+ " . $duration . ' ' . $type, $current_date);
        $date = date('Y-m-d', $date);
        $end_date = $date . " 23:59:59";
        return $end_date;
    }
}


if (!function_exists('make_date')) {
    //duration = 1,2 and type= days,month,year
    function make_date($duration, $type)
    {
        $current_date = strtotime(d_time());
        $date = strtotime("- " . $duration . ' ' . $type, $current_date);
        $date = date('Y-m-d', $date);
        $end_date = $date . " 23:59:59";
        return $end_date;
    }
}

if (!function_exists('make_day')) {
    //duration = 1,2 and type= days,month,year
    function make_day($duration, $type)
    {
        $current_date = strtotime(d_time());
        $date = strtotime("- " . $duration . ' ' . $type, $current_date);
        $date = date('Y-m-d', $date);
        $end_date = $date;
        return $end_date;
    }
}


if (!function_exists('get_last_date')) {
    //duration = 1,2 and type= days,month,year
    function get_last_date($duration, $type, $date)
    {
        $current_date = strtotime($date);
        $date = strtotime("- " . $duration . ' ' . $type, $current_date);
        $date = date('Y-m-d', $date);
        return $date;
    }
}



if (!function_exists('day_left')) {
    function day_left($start, $end)
    {
        $datetime1 = date_create($start);
        $datetime2 = date_create($end);
        $interval = date_diff($datetime1, $datetime2);
        $date_differ =  $interval->format('%a');
        if ($end == '' || $end == '0000-00-00 00:00:00' || empty($end)) :
            $date = 0;
            $left = lang('lifetime');
        else :
            if ($datetime1 <= $datetime2) :
                if ($date_differ == "0") {
                    $date =  "Tonight";
                    $left =  0;
                } else {
                    $left =  $date_differ . ' ' . (!empty(lang('days_left')) ? lang('days_left') : "days left");
                    $date =  $date_differ;
                }
            else :
                $date = '-' . $date_differ;
                $left =  '-' . $date_differ . ' ' . lang('days_ago');
            endif;
        endif;

        return ['day_left' => $left, 'date' => $date];
    }
}







if (!function_exists('time_zone')) {

    function time_zone()
    {
        $ci = &get_instance();
        $set_time_zone = settings()['time_zone'] ?? 'Asia/Dhaka'; //Asia/Dhaka
        $date = new DateTime();
        $timeZone = $date->getTimezone();
        !empty($set_time_zone) ? $get_zone = $set_time_zone : $get_zone = $timeZone->getName();
        return $get_zone;
    }
}


if (!function_exists('full_date')) {
    function full_date($date, $id = 0)
    {

        if ($date != '') {
            $date_new = get_date_format($date, $id);
            return $date_new;
        } else {
            return '';
        }
    }
}


if (!function_exists('get_date_format')) {
    function get_date_format($date, $id = 0)
    {
        if ($date == '' || $date == '0000-00-00 00:00:00') {
            return '';
        }
        
        try {
            // Obter o formato de data configurado pelo usuário
            $type = $id != 0 ? shop($id)->date_format : 3; // Usar formato dd/mm/yyyy como padrão
            
            // Criar objeto de data a partir da string
            $date_obj = date_create($date);
            if (!$date_obj) {
                return '';
            }
            
            // Array de formatos de data disponíveis
            $formats = [
                1 => 'd-m-Y',       // 31-12-2023
                2 => 'Y-m-d',       // 2023-12-31
                3 => 'd/m/Y',       // 31/12/2023
                4 => 'Y/m/d',       // 2023/12/31
                5 => 'd.m.Y',       // 31.12.2023
                6 => 'Y.m.d',       // 2023.12.31
                7 => 'd M, Y',      // 31 Dec, 2023
                8 => 'd M Y',       // 31 Dec 2023
            ];
            
            // Verificar se o formato existe, caso contrário usar o formato padrão
            $format = isset($formats[$type]) ? $formats[$type] : $formats[3];
            
            // Formatar a data usando o formato escolhido
            $formatted_date = date_format($date_obj, $format);
            
            // Se o formato contiver 'M', traduzir o nome do mês para português
            if (strpos($format, 'M') !== false) {
                $en_months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $pt_months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
                
                $formatted_date = str_replace($en_months, $pt_months, $formatted_date);
            }
            
            return $formatted_date;
        } catch (Exception $e) {
            log_message('error', 'Erro em get_date_format: ' . $e->getMessage());
            return $date; // Retorna a data original em caso de erro
        }
    }
}

if (!function_exists('time_format')) {
    function time_format($date, $id = 0)
    {
        if ($date == '' || $date == '0000-00-00 00:00:00') {
            return '';
        }
        
        try {
            // Obter o formato de hora configurado pelo usuário
            $type = $id != 0 ? shop($id)->time_format : 1;
            
            // Criar objeto de data a partir da string
            $date_obj = date_create($date);
            if (!$date_obj) {
                return '';
            }
            
            // Formatos de hora disponíveis
            $formats = [
                1 => 'h:i a',  // 12h com AM/PM (e.g., 3:30 pm)
                2 => 'H:i',    // 24h (e.g., 15:30)
            ];
            
            // Usar o formato correto ou o padrão se não existir
            $format = isset($formats[$type]) ? $formats[$type] : $formats[1];
            
            // Formatar a hora
            $formatted_time = date_format($date_obj, $format);
            
            // Se for formato 12h, traduzir AM/PM para português
            if ($type == 1) {
                $formatted_time = str_ireplace(['am', 'pm'], ['am', 'pm'], $formatted_time);
            }
            
            return $formatted_time;
        } catch (Exception $e) {
            log_message('error', 'Erro em time_format: ' . $e->getMessage());
            return $date; // Retorna a data original em caso de erro
        }
    }
}

if (!function_exists('get_time')) {
    function get_time($date = '')
    {

        return date('h:i a', strtotime($date ?? d_time()));
    }
}

if (!function_exists('slot_time_format')) {
    function slot_time_format($date, $id = 0)
    {
        if ($date == '' || empty($date)) {
            return '';
        }
        
        try {
            // Obter o formato de hora configurado pelo usuário
            $type = $id != 0 ? shop($id)->time_format : 1;
            
            // Dividir o slot em hora inicial e final
            $get_time = explode('-', $date);
            if (count($get_time) != 2) {
                return $date; // Retorna original se não tiver o formato esperado
            }
            
            $date1 = trim($get_time[0]);
            $date2 = trim($get_time[1]);
            
            // Criar objetos de data
            $time1 = date_create($date1);
            $time2 = date_create($date2);
            
            if (!$time1 || !$time2) {
                return $date;
            }
            
            // Formatos de hora disponíveis
            $formats = [
                1 => 'h:i a',  // 12h com AM/PM (e.g., 3:30 pm - 4:30 pm)
                2 => 'H:i',    // 24h (e.g., 15:30 - 16:30)
            ];
            
            // Usar o formato correto ou o padrão se não existir
            $format = isset($formats[$type]) ? $formats[$type] : $formats[1];
            
            // Formatar as horas
            $formatted_time1 = date_format($time1, $format);
            $formatted_time2 = date_format($time2, $format);
            
            // Se for formato 12h, traduzir AM/PM para português
            if ($type == 1) {
                $formatted_time1 = str_ireplace(['am', 'pm'], ['am', 'pm'], $formatted_time1);
                $formatted_time2 = str_ireplace(['am', 'pm'], ['am', 'pm'], $formatted_time2);
            }
            
            return $formatted_time1 . ' - ' . $formatted_time2;
        } catch (Exception $e) {
            log_message('error', 'Erro em slot_time_format: ' . $e->getMessage());
            return $date; // Retorna a data original em caso de erro
        }
    }
}

if (!function_exists('full_time')) {
    function full_time($date, $id = 0)
    {
        if ($date == '' || $date == '0000-00-00 00:00:00') {
            return '';
        }
        
        try {
            // Cria o objeto de data
            $date_obj = date_create($date);
            
            // Se a data for inválida, retorna uma string vazia
            if (!$date_obj) {
                return '';
            }

            // Obtém a configuração de formato de data do usuário
            $date_format_type = $id != 0 ? shop($id)->date_format : 8;
            
            // Obtém a configuração de formato de hora do usuário
            $time_format_type = $id != 0 ? shop($id)->time_format : 1;
            
            // Configura o formato de hora (12h ou 24h)
            $time_format = $time_format_type == 1 ? 'h:i a' : 'H:i';
            
            // Formata a hora de acordo com a configuração
            $time = date_format($date_obj, $time_format);
            
            // Se for formato 12h, converte am/pm para minúsculas em português
            if ($time_format_type == 1) {
                $time = str_ireplace(['am', 'pm'], ['am', 'pm'], $time);
            }
            
            // Usa a função get_date_format para formatar a data conforme configuração
            $formatted_date = get_date_format($date, $id);
            
            // Retorna a data formatada com o horário
            return $formatted_date . ' ' . $time;
        } catch (Exception $e) {
            log_message('error', 'Erro em full_time: ' . $e->getMessage());
            return $date; // Em caso de erro, retorna a data original
        }
    }
}

if (!function_exists('cl_format')) {
    function cl_format($date, $id = 0)
    {
        if ($date == '' || $date == '0000-00-00 00:00:00') {
            return '';
        }
        
        try {
            // Cria o objeto de data
            $date_obj = date_create($date);
            
            // Se a data for inválida, retorna uma string vazia
            if (!$date_obj) {
                return '';
            }
            
            // Obtém a configuração de formato de data do usuário
            $date_format_type = $id != 0 ? shop($id)->date_format : 8;
            
            // Se o formato escolhido for um dos formatos estilo "d M Y", usamos o formato longo de mês
            if ($date_format_type == 7 || $date_format_type == 8) {
                // Extrai o dia e o ano
                $day = date_format($date_obj, "d");
                $year = date_format($date_obj, "Y");

                // Array de meses em português
                $months = [
                    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
                    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
                    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                ];
                
                // Obtém o número do mês e o nome correspondente
                $month_number = date_format($date_obj, "n");
                $month_name = isset($months[$month_number]) ? $months[$month_number] : '';

                // Retorna o formato no estilo "13 Janeiro, 2025"
                return "$day $month_name, $year";
            } else {
                // Para outros formatos, usa a função get_date_format
                return get_date_format($date, $id);
            }
        } catch (Exception $e) {
            log_message('error', 'Erro em cl_format: ' . $e->getMessage());
            return $date; // Em caso de erro, retorna a data original
        }
    }
}


if (!function_exists('year')) {

    function year($date)
    {
        if (!empty($date)) {
            $date = $date;
        } else {
            $date = today();
        }
        $ci = get_instance();
        $date = date_create($date);
        return date_format($date, "Y");
    }
}

if (!function_exists('year_month')) {

    function year_month($date)
    {
        $ci = get_instance();
        if (!empty($date)) {
            $date = $date;
        } else {
            $date = today();
        }
        $date = date_create($date);
        return date_format($date, "Y-m");
    }
}

if (!function_exists('month_year_name')) {

    function month_year_name($date)
    {
        $ci = get_instance();
        if (!empty($date)) {
            $date = $date;
        } else {
            $date = today();
        }
        $date = date_create($date);
        return date_format($date, "F Y");
    }
}
if (!function_exists('month')) {

    function month($date)
    {
        if (!empty($date)) {
            $date = $date;
        } else {
            $date = today();
        }
        $ci = get_instance();
        $date = date_create($date);
        return date_format($date, "m");
    }
}

if (!function_exists('day')) {

    function day($date)
    {
        $ci = get_instance();
        $timestamp = strtotime($date);
        return date("d", $timestamp);
    }
}


if (!function_exists('month_name')) {

    function month_name($date)
    {

        $ci = get_instance();
        $month = month($date);
        $monthName = date("F", mktime(0, 0, 0, $month, 10));
        return $monthName;
    }
}

if (!function_exists('date_time')) {

    function date_time($date)
    {
        $ci = get_instance();

        if (!empty($date)) {
            // Se a data já estiver no formato Y-m-d, mantenha-a assim
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return $date;
            }
            
            // Se a data estiver no formato d/m/Y, converte para Y-m-d
            if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
                $dateParts = explode('/', $date);
                if (count($dateParts) === 3) {
                    return "{$dateParts[2]}-{$dateParts[1]}-{$dateParts[0]}";
                }
            }
            
            // Para outros formatos, usa o DateTime
            $date = $date;
        } else {
            $date = today();
        }
        $date = date_create($date);
        return date_format($date, "Y-m-d");
    }
}


if (!function_exists('time_format_12')) {
    function time_format_12($time)
    {

        if ($time != '') {
            $time2 = date_create($time);
            $ne_time = date_format($time2, "h:i a");
            return $ne_time;
        } else {
            return '';
        }
    }
}
/*----------------------------------------------
        
         Custom date time
         ----------------------------------------------*/



//session  data
if (!function_exists('auth')) {
    function auth($string, $arr = [])
    {
        $ci = &get_instance();
        if (!empty($arr)) {
            $arrData = $ci->session->userdata($arr);
            if (is_array($arrData) && isset($arrData[$string])) {
                return $arrData[$string];
            }
            return NULL;
        }


        $data = $ci->session->userdata($string);

        if (is_string($data)) {
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }

        return $data;
    }
}



if (!function_exists('get_layout_img')) {
    function get_layout_img($img)
    {
        if (!empty($img)) {
            $image = $img;
        } else {
            $image = 'assets/images/home_banner.jpg';
        }
        return base_url($image);
    }
}



if (!function_exists('lang')) {
    function lang($data)
    {
        $ci = get_instance();
        $data = strtolower($data);
        return !empty($ci->lang->line($data)) ? $ci->lang->line($data) : '';
    }
}

if (!function_exists('get_lang')) {
    function get_lang($lang = '')
    {
        $ci = &get_instance();
        if (!empty($lang)) {
            $data = $lang;
        } else {
            $data = site_lang();
        };

        return $data;
    }
}

if (!function_exists('direction')) {
    function direction($lang = null)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        if (!empty($lang)) {
            $lang = $lang;
        } else {
            $lang = get_lang();
        }
        $data = $ci->admin_m->get_languages_by_slug($lang);
        return isset($data['direction']) ? $data['direction'] : "";
    }
}

if (!function_exists('get_auth_info')) {
    function get_auth_info()
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_auth_info();
        return $data;
    }
}

if (!function_exists('user')) {
    function user()
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_users_info();
        return isset($data) && !empty($data) ? $data : 0;
    }
}


if (!function_exists('staff_info')) {
    function staff_info()
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_staff_info();
        return isset($data) && !empty($data) ? $data : 0;
    }
}

if (!function_exists('staff')) {
    function staff($id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->staff_info($id);
        return isset($data) && !empty($data) ? $data : '';
    }
}

if (!function_exists('user_info_by_id')) {
    function user_info_by_id($id)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->user_info_by_id($id);
        return $data;
    }
}

if (!function_exists('get_user_info')) {
    function get_user_info()
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_user_info();
        return $data;
    }
}

if (!function_exists('get_user_info_by_id')) {
    function get_user_info_by_id($id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_user_info_by_id($id);
        return !empty($data) ? $data : [];
    }
}



if (!function_exists('valid_user')) {
    function valid_user($id)
    {
        $ci = get_instance();
        if (auth('id') != $id) {
            redirect(base_url('dashboard'));
            $ci->session->set_flashdata('warning', 'Sorry User not Match');
        }
    }
}

if (!function_exists('staff')) {
    function staff($id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->customer_info($id);
        return $data;
    }
}

if (!function_exists('get_id_by_package_slug')) {
    function get_info_by_package_slug($slug)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_info_by_package_slug($slug);
        return $data;
    }
}


if (!function_exists('asset_url')) {
    function asset_url($uri = '')
    {
        $ci = &get_instance();
        return $ci->config->item('base_url') . $uri;
    }
}

if (!function_exists('settings')) {
    function settings()
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_settings();
        return $data;
    }
}
if (!function_exists('st')) {
    function st()
    {
        $ci = &get_instance();
        $ci->load->model('default_m');
        $data = $ci->default_m->settings();
        return $data ?? '';
    }
}

if (!function_exists('single_select_by_id')) {
    function single_select_by_id($id, $table)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->single_select_by_id($id, $table);
        return $data ?? [];
    }
}


if (!function_exists('s_id')) {
    function s_id($id, $table)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->single_select_by_id_row($id, $table);
        return $data;
    }
}

if (!function_exists('single')) {
    function single($id, $table)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->single_id($id, $table);
        return $data;
    }
}

// check valid auth/admin
if (!function_exists('check_valid_auth')) {

    function check_valid_auth()
    {
        $ci = get_instance();
        if (auth('is_login')) :
            if (auth('is_auth') == true) {
                if (auth('user_role') != 1) {
                    redirect(base_url('dashboard'));
                }
            } else {
                redirect(base_url('dashboard'));
            }
        else :
            $ci->session->sess_destroy();
            redirect(base_url('login'));
        endif;
    }
}

// check valid user
if (!function_exists('check_valid_user')) {

    function check_valid_user()
    {
        $ci = get_instance();
        if (auth('is_user') == true) {
            if (auth('user_role') == 1) {
                redirect(base_url('dashboard'));
            }
        } else {
            $ci->session->sess_destroy();
            redirect(base_url('login'));
        }
    }
}

// check valid user
if (!function_exists('is_login')) {

    function is_login()
    {
        $ci = get_instance();
        if (auth('is_login') == true) {
            redirect(base_url('dashboard'));
        } else {
            $ci->session->sess_destroy();
            redirect(base_url('login'));
        }
    }
}



if (!function_exists('d_auth')) {
    function d_auth($string)
    {
        $ci = &get_instance();
        if (!empty($ci->session->userdata('discount_ss'))) {
            return $ci->session->userdata('discount_ss')[$string];
        } else {
            return '';
        }
    }
}


if (!function_exists('check_valid_user')) {

    function check_valid_user()
    {
        $ci = get_instance();
        if (auth('is_user') == true) {
            if (auth('user_role') == 1) {
                redirect(base_url('dashboard'));
            }
        } else {
            $ci->session->sess_destroy();
            redirect(base_url('login'));
        }
    }
}

if (!function_exists('check_setting_value')) {
    function check_setting_value($type)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->check_setting_value($type);
        return $data;
    }
}

if (!function_exists('get_country')) {
    function get_country($id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->single_select_by_id($id, 'country');
        return $data;
    }
}

if (!function_exists('csrf')) {
    function csrf()
    {
        $ci = get_instance();
        $data = include APPPATH . 'views/csrf.php';
    }
}

if (!function_exists('users')) {

    function users()
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_user_info();
        return $data;
    }
}


if (!function_exists('admin')) {

    function admin()
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_admin_info();
        return $data;
    }
}

if (!function_exists('restaurant')) {

    function restaurant($id = '')
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->my_restaurant_info($id);
        return isset($data) ? $data : [];
    }
}


if (!function_exists('shop')) {

    function shop($id = '')
    {
        try {
            $ci = get_instance();
            $ci->load->model('admin_m');
            
            // Verificar se o ID é válido
            if (empty($id) || !is_numeric($id)) {
                return (object)[];
            }
            
            $data = $ci->admin_m->get_shop_info($id);
            return isset($data) && !empty($data) ? $data : (object)[];
        } catch (Exception $e) {
            log_message('error', 'Erro na função shop(): ' . $e->getMessage());
            return (object)[];
        }
    }
}


if (!function_exists('shop_info')) {

    function shop_info($id = '')
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_restaurant_info_shop_id($id);
        return isset($data) ? $data : [];
    }
}

//session  data
if (!function_exists('shop_id')) {
    function shop_id($id = '')
    {
        $ci = &get_instance();
        return $ci->admin_m->get_shop_id($id);
    }
}




if (!function_exists('get_days')) {
    function get_days()
    {
        $days = array(
            '0' => 'Domingo',
            '1' => 'Segunda',
            '2' => 'Terça',
            '3' => 'Quarta',
            '4' => 'Quinta',
            '5' => 'Sexta',
            '6' => 'Sábado',
        );
        return $days;
    }
}

if (!function_exists('get_off_days')) {
    function get_off_days($type = 'days')
    {
        $days = array(
            '0' => lang('Domingo'),
            '1' => lang('Segunda'),
            '2' => lang('Terça'),
            '3' => lang('Quarta'),
            '4' => lang('Quinta'),
            '5' => lang('Sexta'),
            '6' => lang('Sábado'),
        );
        if ($type == 'days') :
            return $days;
        else :
            return $days[$type];
        endif;
    }
}

if (!function_exists('get_month')) {
    function get_month()
    {
        $days = array(
            '01' => 'Jan',
            '02' => 'Fev',
            '03' => 'Mar',
            '04' => 'Abr',
            '05' => 'Mai',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Ago',
            '09' => 'Set',
            '10' => 'Out',
            '11' => 'Nov',
            '12' => 'Dez',
        );
        return $days;
    }
}

if (!function_exists('get_currency')) {
    function get_currency($type)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $setting = $ci->admin_m->get_settings();
        if (isset($setting['currency']) && ($setting['currency'] != 0 || $setting['currency'] != '')) :
            $data = $ci->admin_m->get_currency($setting['currency']);
        else :
            $data = array(
                'currency_code' => 'USD',
                'icon' => '&#36;',
            );
        endif;
        return $data[$type];
    }
}

/**===== get_price_feature_id ====**/

if (!function_exists('get_price_feature_id')) {
    function get_price_feature_id($id, $type_id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_price_feature_id($id, $type_id);
        return $data;
    }
}

if (!function_exists('get_active_package_features')) {
    function get_active_package_features($id, $type_id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_active_package_features($id, $type_id);
        return $data;
    }
}



/**
 ***  single_select_by_section_name
 **/

if (!function_exists('get_by_section_name')) {
    function get_by_section_name($section_name)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->single_select_by_section_name($section_name);
        return $data;
    }
}

if (!function_exists('section_name')) {
    function section_name($section_name)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->single_select_by_section_name($section_name);
        return isset($data) && !empty($data) ? $data : [];
    }
}

/**
 *** Get user info by slug
 **/

if (!function_exists('get_all_user_info_slug')) {
    function get_all_user_info_slug($slug)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_all_user_info_slug($slug);
        return $data;
    }
}

/**
 *** Get user info by slug
 **/

if (!function_exists('get_all_user_info_id')) {
    function get_all_user_info_id($id)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_all_user_info_id($id);
        return $data;
    }
}

if (!function_exists('allergens')) {
    function allergens($id, $image = false)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_allergens($id);
        $name = [];
        foreach ($data as $key => $value) {
            $name[] = $value['name'];
        }
        if ($image == true) {
            return $data;
        } else {
            return implode(', ', $name);
        }
    }
}

/**
 ***  redirect url via social media
 **/

if (!function_exists('redirect_url')) {
    function redirect_url($value, $slug, $dial_code = '', $text = '')
    {

        $ci = &get_instance();
        if ($slug == "whatsapp") :
            $url = 'https://api.whatsapp.com/send?phone=' . $dial_code . $value . "&text=" . urlencode($text);
        elseif ($slug == "phone") :
            $url = 'tel:' . $dial_code . $value;
        elseif ($slug == "email") :
            $url = 'mailto:' . $value;
        else :
            $url = prep_url($value);
        endif;
        return $url;
    }
}

/**
 ***  redirect url via social media
 **/

if (!function_exists('get_package_type')) {
    function get_package_type($value, $duration = '', $period = '')
    {

        $ci = &get_instance();
        if (strtolower($value) == "yearly") :
            $url = !empty(lang('year')) ? lang('year') : 'Year';
        elseif (strtolower($value) == "monthly") :
            $url = !empty(lang('month')) ? lang('month') : 'Month';
        elseif (strtolower($value) == "half_yearly" || strtolower($value) == "half_year") :
            $url = !empty(lang('6_month')) ? lang('6_month') : '6 Months';;
        elseif (strtolower($value) == "custom") :
            $url = $duration . ' ' . lang($period);
        else :
            $url = '';
        endif;
        return $url;
    }
}


if (!function_exists('package_type')) {
    function package_type($type, $duration, $period)
    {

        $ci = &get_instance();
        if ($type == "custom") {
            return $duration . ' ' . lang($period);
        } else {
            return lang($type);
        }
    }
}


if (!function_exists('package_type_list')) {
    function package_type_list()
    {

        $ci = &get_instance();
        $data = [
            'trial' => !empty(lang('trial_for_month')) ? lang('trial_for_month') : "Trial for 1 Month",
            'weekly' => !empty(lang('trial_for_week')) ? lang('trial_for_week') : "Trial for 1 week",
            'fifteen' => !empty(lang('trial_for_fifteen')) ? lang('trial_for_fifteen') : "Trial for 15 days",
            'free' => !empty(lang('free')) ? lang('free') : "Free",
            'monthly' => !empty(lang('monthly')) ? lang('monthly') : "Monthly",
            'half_yearly' => !empty(lang('6_month')) ? lang('6_month') : "6 Months",
            'yearly' => !empty(lang('yearly')) ? lang('yearly') : "Yearly",
            'custom' => !empty(lang('custom_days')) ? lang('custom_days') : "Custom Days",
        ];
        return $data;
    }
}


if (!function_exists('get_total_income')) {
    function get_total_income()
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_total_income();
        return $data;
    }
}


if (!function_exists('income')) {
    function income($month, $type)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_total_income_by_month($month, $type);
        return $data;
    }
}
if (!function_exists('user_income')) {
    function user_income($month, $type)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_user_total_income_by_month($month, $type);
        return $data;
    }
}

if (!function_exists('get_package_info_by_slug')) {
    function get_package_info_by_slug($slug)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_package_info_by_slug($slug);
        return $data;
    }
}
if (!function_exists('get_package_info_by_id')) {
    function get_package_info_by_id($id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_package_info_by_id($id);
        return isset($data) && !empty($data) ? $data : 0;
    }
}


/*  profile
================================================== */

// get user layout by slug
if (!function_exists('get_view_layouts_by_slug')) {

    function get_view_layouts_by_slug($slug)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_layouts_by_slug($slug);
        return 'theme' . $data;
    }
}

// get user layout by slug
if (!function_exists('get_id_by_slug')) {

    function get_id_by_slug($slug)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_id_by_slug($slug);
        return $data;
    }
}


/**
 ** get freatures for user package
 **/
if (!function_exists('get_user_features_by_id')) {
    function get_user_features_by_id($id, $type_slug)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_user_features_by_id($id, $type_slug);
        return $data['check'];
    }
}



// get user info by slug
if (!function_exists('get_user_info_by_slug')) {

    function get_user_info_by_slug($slug)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_user_info_by_slug($slug);
        return $data;
    }
}

if (!function_exists('is_active')) {
    function is_active($id, $slug)
    {
        $ci = &get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->check_active_features($id, $slug);
        return $data['check'];
    }
}

if (!function_exists('get_features_name')) {
    function get_features_name($slug)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_features_name($slug);
        return !empty(lang($slug)) ? lang($slug) : $data;
    }
}


if (!function_exists('check_layouts')) {
    function check_layouts($type, $value)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->check_layouts($type, $value);
        return $data;
    }
}

if (!function_exists('check_offline_payment')) {
    function check_offline_payment($id)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_payment_type_by_id($id);
        return $data;
    }
}

if (!function_exists('total_type')) {
    function total_type($type)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_total_user_by_type($type);
        return $data;
    }
}


if (!function_exists('get_heading')) {
    function get_heading($id, $user_id, $type)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $feature = $ci->admin_m->get_features_name_id($id);
        $data = $ci->admin_m->get_features_heading($id, $user_id);
        if ($type == 1) {
            return isset($data) && !empty($data['heading']) ? $data['heading'] : $feature;
        } else {
            return isset($data) && !empty($data['sub_heading']) ? $data['sub_heading'] : '';
        }
    }
}

if (!function_exists('get_title')) {
    function get_title($user_id, $slug, $type)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $feature = $ci->admin_m->get_features_name($slug);
        $data = $ci->admin_m->get_features_title($slug, $user_id);
        if ($type == 1) {
            return isset($data) && !empty($data['heading']) ? $data['heading'] : $feature;
        } else {
            return isset($data) && !empty($data['sub_heading']) ? $data['sub_heading'] : '';
        }
    }
}

if (!function_exists('get_times')) {
    function get_times()
    {
        $ci = get_instance();
        $dt = new DateTime('now', new DateTimezone(time_zone()));
        return $date_time = $dt->format('G:i');
    }
}

if (!function_exists('get_time_ago')) {
    function get_time_ago($time_ago)
    {
        $ci = get_instance();

        $dt = new DateTime('now', new DateTimezone(time_zone()));
        $date_time = strtotime($dt->format('Y-m-d H:i:s'));

        $time_ago = strtotime($time_ago);
        $cur_time   = $date_time;
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed;
        $minutes    = round($time_elapsed / 60);
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400);
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640);
        $years      = round($time_elapsed / 31207680);
        // Seconds

        //return $seconds;

        if ($seconds <= 60) {
            return lang('just_now');
        }
        //Minutes
        elseif ($minutes <= 60) {
            if ($minutes == 1) {
                return lang('one_min_ago');
            } else {
                return "$minutes " . lang('minutes_ago');
            }
        }
        //Hours
        elseif ($hours <= 24) {
            if ($hours == 1) {
                return lang('an_hour_ago');
            } else {
                return "$hours " . lang('hrs_ago');
            }
        }
        //Days
        elseif ($days <= 7) {
            if ($days == 1) {
                return lang('yesterday');
            } else {
                return "$days " . lang('days_ago');
            }
        }
        //Weeks
        elseif ($weeks <= 4.3) {
            if ($weeks == 1) {
                return lang('a_week_ago');
            } else {
                return "$weeks " . lang('weeks_ago');
            }
        }
        //Months
        elseif ($months <= 12) {
            if ($months == 1) {
                return lang('a_month_ago');
            } else {
                return "$months " . lang('months_ago');
            }
        }
        //Years
        else {
            if ($years == 1) {
                return lang('one_year_ago');
            } else {
                return "$years " . lang('years_ago');
            }
        }
    }
}



if (!function_exists('time_ago')) {
    function time_ago($date_2, $date_1)
    {
        $ci = get_instance();

        $date_time = strtotime($date_1);

        $time_ago = strtotime($date_2);
        $cur_time   = $date_time;
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed;
        $minutes    = round($time_elapsed / 60);
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400);
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640);
        $years      = round($time_elapsed / 31207680);
        // Seconds

        //return $seconds;

        if ($seconds <= 60) {
            return lang('just_now');
        }
        //Minutes
        elseif ($minutes <= 60) {
            if ($minutes == 1) {
                return lang('one_min_ago');
            } else {
                return "$minutes " . lang('minutes_ago');
            }
        }
        //Hours
        elseif ($hours <= 24) {
            if ($hours == 1) {
                return lang('an_hour_ago');
            } else {
                return "$hours " . lang('hrs_ago');
            }
        }
        //Days
        elseif ($days <= 7) {
            if ($days == 1) {
                return lang('yesterday');
            } else {
                return "$days " . lang('days_ago');
            }
        }

        //Years
        else {
            return full_time($date_2);
        }
    }
}



if (!function_exists('delete_image_from_server')) {
    function delete_image_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}


if (!function_exists('is_xs')) {
    function is_xs($id)
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $info = $ci->admin_m->get_user_info_by_id($id);
        if ($info['theme'] == 1 || $info['theme'] == 3) {
            return '1';
        } else {
            return 'xs-container';
        }
    }
}

if (!function_exists('veg_type')) {
    function veg_type($type)
    {
        $ci = &get_instance();

        if ($type == 1) {
            return !empty(lang('veg')) ? lang('veg') : 'Veg';
        } elseif ($type == 2) {
            return !empty(lang('non_veg')) ? lang('non_veg') : 'Non veg';
        }
    }
}

if (!function_exists('get_payment_type')) {
    function get_payment_type($type)
    {
        $ci = &get_instance();
        if ($type == '0') {
            $payment = 'offline';
        } elseif ($type == '1') {
            $payment = 'paypal';
        } elseif ($type == '2') {
            $payment = 'stripe';
        } elseif ($type == '3') {
            $payment = 'razorpay';
        } else {
            $payment = $type;
        }
        return $payment;
    }
}


if (!function_exists('order_type')) {
    function order_type($type)
    {
        $ci = &get_instance();
        $type_name = $ci->common_m->single_select_by_id($type, 'order_types');
        return !empty(lang($type_name['slug'])) ? lang($type_name['slug']) : (!empty($type_name['name']) ? $type_name['name'] : '');
    }
}


if (!function_exists('get_indexing')) {
    function get_indexing($limit)
    {
        $ci = &get_instance();
        $item_array = [];
        for ($i = 0; $i <= $limit; $i++) {
            $n = 2 * $i;
            $j = 2 * $n + 3;
            $k = $j + 1;
            array_push($item_array, $j, $k);
        }
        return $item_array;
    }
}

if (!function_exists('get_embeded')) {
    function get_embeded($url)
    {
        $ci = &get_instance();
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return 'https://www.youtube.com/embed/' . $youtube_id;
    }
}

if (!function_exists('get_youtube_id')) {
    function get_youtube_id($url)
    {
        $ci = &get_instance();
        $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
        $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

        if (preg_match($longUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }

        if (preg_match($shortUrlRegex, $url, $matches)) {
            $youtube_id = $matches[count($matches) - 1];
        }
        return  $youtube_id;
    }
}

//youtube thumbnail
if (!function_exists('get_youtube_thumb')) {
    function get_youtube_thumb($link)
    {
        $video_id = explode("?v=", $link);
        if (!isset($video_id[1])) {
            $video_id = explode("youtu.be/", $link);
        }
        $youtubeID = $video_id[1];
        if (empty($video_id[1])) {
            $video_id = explode("/v/", $link);
        }
        $video_id = explode("&", $video_id[1]);
        $youtubeVideoID = $video_id[0];

        $img_name = md5('youtube' . time());
        if ($youtubeVideoID) {
            return $thumbURL = 'https://img.youtube.com/vi/' . $youtubeVideoID . '/mqdefault.jpg';
        } else {
            return false;
        }
    }
}


if (!function_exists('submit_btn')) {
    function submit_btn()
    {
        $ci = &get_instance();
        return '<button type="submit" class="btn btn-primary primary-light c_btn"> ' . (!empty(lang('submit')) ? lang('submit') : " ") . ' <i class="icofont-rounded-double-right"></i> </button>';
    }
}


if (!function_exists('order_limit')) {
    function order_limit($type = '')
    {

        $ci = &get_instance();
        $array = array(
            '0' => lang('unlimited'),
            '10' => 10,
            '15' => 15,
            '20' => 20,
            '30' => 30,
            '50' => 50,
        );
        if (is_numeric($type)) :
            return $array[$type];
        else :
            return $array;
        endif;
    }
}


if (!function_exists('item_limit')) {
    function item_limit($type = 'all')
    {

        $ci = &get_instance();
        $array = array(
            '0' => lang('unlimited'),
            '10' => 10,
            '15' => 15,
            '20' => 20,
            '30' => 30,
            '40' => 40,
            '50' => 50,
        );
        if (is_numeric($type)) :
            return $array[$type];
        else :
            return $array;
        endif;
    }
}


if (!function_exists('limit_text')) {
    function limit_text($type)
    {

        $ci = &get_instance();
        if ($type == 0) {
            return lang('unlimited');
        } else {
            return $type;
        }
    }
}






if (!function_exists('delivery_area')) {
    function delivery_area($id = 0)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_delivery_area($id);
        return $data;
    }
}


if (!function_exists('shipping')) {
    function shipping($id, $shop_id)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->delivery_area_by_shop_id($id, $shop_id);
        return $data;
    }
}



if (!function_exists('limit')) {
    function limit($id, $type)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_user_limit($id, $type);
        return $data;
    }
}
if (!function_exists('is_access')) {
    function is_access($type)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->check_permission($type);
        return $data;
    }
}





if (!function_exists('is_feature')) {
    function is_feature($id, $type_slug)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_user_pricing_by_id($id, $type_slug);
        return $data['check'];
    }
}

if (!function_exists('trial_type')) {
    function trial_type()
    {
        $ci = get_instance();
        return ['trial', 'weekly', 'fifteen'];
    }
}

if (!function_exists('sms_settings')) {
    function sms_settings($id)
    {
        $ci = get_instance();
        $settings = u_settings($id);
        $info = !empty($settings['twillo_sms_settings']) ? json_decode($settings['twillo_sms_settings']) : '';
        if (isset($info) && !empty($info)) {
            return $info;
        } else {
            return [];
        }
    }
}


if (!function_exists('create_msg')) {
    function create_msg($data, $msg)
    {
        $ci = get_instance();
        $find       = array_keys($data);
        $replace    = array_values($data);
        $new_msg = str_ireplace($find, $replace, $msg);
        if (!empty($new_msg)) {
            return $new_msg;
        } else {
            return '';
        }
    }
}


if (!function_exists('u_settings')) {
    function u_settings($id)
    {
        $ci = get_instance();
        $ci->load->model('common_m');
        $data = $ci->common_m->get_user_settings($id);
        return !empty($data) ? $data : [];
    }
}


if (!function_exists('get_size')) {
    function get_size($slug, $id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_single_size_by_slug($slug, $id);
        return $data;
    }
}

if (!function_exists('item_size')) {
    function item_size($slug, $item_id, $shop_id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $get_variants = [];
        $data = $ci->admin_m->get_item_sizes($item_id, $shop_id);
        if (!empty($data->variant_options) && is_array($data->variant_options)) {
            foreach ($data->variant_options as $key => $v) :
                if ($v->slug == $slug) {
                    $get_variants[] = (array)$v;
                }
            endforeach;
            if (isset($get_variants[0])) {
                return (object) array_merge($get_variants[0], ['variant_name' => $data->variant_name]);
            } else {
                return [];
            }
        } else {
            return [];
        }
    }
}

if (!function_exists('variants')) {
    function variants($slug, $item_id, $shop_id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $item_size = item_size($slug, $item_id, $shop_id);
        if ((isset($item_size) && !empty($item_size)) && (isset($item_size->variant_name) && !empty($item_size->variant_name))) {
            return "<span class='sizeTitle'>" . $item_size->variant_name . ": </span> <span class='sizeValue'>" . $item_size->name . "</span>";
        } else {
            return "<span class='sizeTitle'>" . lang('size') . ": </span> <span class='sizeValue'>" . $ci->admin_m->get_size_by_slug($slug, shop($shop_id)->user_id) . "</span>";
        }
    }
}

if (!function_exists('extras')) {
    function extras($id, $item_id)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_extras_by_id($id, $item_id);
        return !empty($data) ? $data : '';
    }
}



if (!function_exists('number')) {
    function number($num)
    {
        $ci = get_instance();
        return str_replace(',', '', $num);
    }
}




if (!function_exists('size')) {
    function size($type, $user_id, $index)
    {
        $ci = get_instance();
        $ci->load->model('admin_m');
        $data = $ci->admin_m->get_size_by_type($type, $user_id);
        return isset($data[$index]) && !empty($data[$index]) ? $data[$index] : '';
    }
}
if (!function_exists('get_size_type')) {
    function get_size_type($type = 'all')
    {
        $ci = &get_instance();
        $array = ['pizza' => 'p_size_', 'burger' => 'b_size_', 'weight' => 'w_size', 'calories' => 'c_size', 'sizes' => 's_size'];
        if (is_numeric($type)) :
            return $array[$type];
        else :
            return $array;
        endif;
    }
}


if (!function_exists('getTimeSlot')) {
    function getTimeSlot($interval, $start_time, $end_time)
    {
        $ci = &get_instance();

        $start = new DateTime($start_time);
        $end = new DateTime($end_time);
        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');
        $i = 0;
        $time = [];
        while (strtotime($startTime) <= strtotime($endTime)) {
            $start = $startTime;
            $end = date('H:i', strtotime('+' . $interval . ' minutes', strtotime($startTime)));
            $startTime = date('H:i', strtotime('+' . $interval . ' minutes', strtotime($startTime)));
            $i++;
            if (strtotime($startTime) <= strtotime($endTime)) {
                $time[$i]['slot_start_time'] = $start;
                $time[$i]['slot_end_time'] = $end;
            }
        }
        return $time;
    }
}

if (!function_exists('my_currency')) {
    function my_currency($id, $type = '')
    {
        $ci = &get_instance();
        $ci->load->model('admin_m');
        $info = $ci->admin_m->single_select_by_id($id, 'country');
        if (isset($info) && !empty($info)) :
            $data = $info;
        else :
            $data = array(
                'currency_code' => 'USD',
                'currency_symbol' => '&#36;',
            );
        endif;
        return isset($data[$type]) ? $data[$type] : 0;
    }
}









if (!function_exists('get_img')) {
    function get_img($img = '', $img_url = '', $img_type = '')
    {
        $ci = &get_instance();
        if ($img_type == 1) :
            return base_url(!empty($img) ? $img : EMPTY_IMG);
        elseif ($img_type == 2) :
            return !empty($img_url) ? $img_url : base_url(EMPTY_IMG);
        endif;
    }
}

if (!function_exists('avatar')) {
    function avatar($img = '', $type = 'profile')
    {
        $ci = &get_instance();
        if (!empty($img) && file_exists($img)) {
            return base_url($img);
        } else {
            if ($type == 'profile') {
                return base_url(AVATAR);
            } else {
                return base_url(EMPTY_IMG);
            }
        }
    }
}


if (!function_exists('get_percent')) {
    function get_percent($amount, $percent, $is_pos = 0)
    {
        $ci = &get_instance();
        if ($amount == 0 || $amount == "0") {
            return 0;
        } else {
            if ($is_pos == 1) {
                return $percent;
            } else {
                return ($amount * $percent) / 100;
            }
        }
    }
}

if (!function_exists('get_percent_price')) {
    function get_percent_price($amount, $percent, $is_pos = 0)
    {
        $ci = &get_instance();
        if ($amount == 0 || $amount == "0") {
            return 0;
        } else {
            if ($is_pos == 1) {
                return $percent;
            } else {
                $percent_amount =  (floatval($amount) * intval($percent)) / 100;
                return $amount - $percent_amount;
            }
        }
    }
}


if (!function_exists('grand_total')) {
    function grand_total($amount = 0, $shipping = 0, $discount = 0, $tax = 0, $coupon_percent = 0, $tips = 0, $order_type = 0, $tax_status = '+', $is_pos = 0, $is_item_tax = 0, $service_charge = 0)
    {



        $amount = floatval($amount);
        $shipping = floatval($shipping);
        $discount = floatval($discount);
        $tax = floatval($tax);
        $coupon_percent = floatval($coupon_percent);
        $tips = floatval($tips);
        $service_charge = floatval($service_charge);


        $ci = &get_instance();
        if ($is_item_tax == 1) {
            $tax = $tax;
        } else {
            $tax = $tax;
        }


        if ($is_pos == 1) :
            $discount = $discount;
        else :
            $discount = ($amount * $discount) / 100;
        endif;

        $coupon_percent = ($amount * $coupon_percent) / 100;
        $tips = $tips;




        if ($order_type == 1) {
            if ($is_item_tax == 1) {
                $total = ($amount + $shipping + $tax + $tips + $service_charge) - ($discount + $coupon_percent);
            } else {
                if ($tax_status == "+") :
                    $total = ($amount + $shipping + $tax + $tips + $service_charge) - ($discount + $coupon_percent);
                elseif ($tax_status == '--') :
                    $total = ($amount + $shipping + $tips + $service_charge) - ($discount + $coupon_percent);
                else :
                    $total = ($amount + $shipping + $tips + $service_charge + $tax) - ($discount + $coupon_percent);
                endif;
            }
        } else {

            if ($is_item_tax == 1) {
                $total = ($amount + $tax + $tips + $service_charge) - ($discount + $coupon_percent);
            } else {
                if ($tax_status == "+") :
                    $total = ($amount + $tax + $tips + $service_charge) - ($discount + $coupon_percent);
                elseif ($tax_status == '--') :
                    $total = ($amount + $tips + $service_charge) - ($discount + $coupon_percent);
                else :
                    $total = ($amount + $tips + $service_charge + $tax) - ($discount + $coupon_percent);
                endif;
            }
        }

        return $total;
    }
}


if (!function_exists('get_total')) {
    function get_total($amount = 0, $shipping = 0, $discount = 0, $tax = 0, $coupon_discount = 0, $tips = 0, $tax_status = '+', $service_charge = 0)
    {
        $ci = &get_instance();
        if ($tax_status == "+") {
            return ($amount + $shipping + $tax + $tips + $service_charge) - ($discount + $coupon_discount);
        } elseif ($tax_status == "--") {
            return ($amount + $tips + $shipping + $service_charge) - ($discount + $coupon_discount);
        } else {
            return ($amount + $shipping + $tips + $service_charge + $tax) - ($discount + $coupon_discount);
        }
    }
}



if (!function_exists('getCoordinatesAttribute')) {
    function getCoordinatesAttribute($url, $shop_id)
    {
        $ci = get_instance();
        $search = 'maps.google.com';
        if (preg_match("/{$search}/i", $url)) :
            $url_coordinates_position = strpos($url, '@') + 1;
            $coordinates = [];

            if ($url_coordinates_position != false) {
                $coordinates_string = substr($url, $url_coordinates_position);
                $coordinates_array = explode(',', $coordinates_string);

                if (count($coordinates_array) >= 2) {
                    $longitude = $coordinates_array[0];
                    $latitude = $coordinates_array[1];

                    $coordinates = [
                        "longitude" => $longitude,
                        "latitude" => $latitude
                    ];
                }

                return $coordinates;
            };
        else :
            $gmap_key = gmap_key($shop_id);
            $address = str_replace(" ", "+", $url);
            $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address={$address}&key={$gmap_key}");
            $json = isset($json) && !empty($json) ? json_decode($json) : [];
            if (!empty(isset($json->{'results'}[0]))) :
                $coordinates = [
                    "longitude" => $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'},
                    "latitude" => $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}
                ];
            else :
                $coordinates = [
                    "longitude" => '',
                    "latitude" => ''
                ];
            endif;
        endif;

        return $coordinates;
    }
}

if (!function_exists('gmap_key')) {

    function gmap_key($id)
    {
        $ci = get_instance();
        $shop = shop($id);
        $gmap_settings = !empty(settings()['gmap_config']) ? json_decode(settings()['gmap_config']) : '';
        if ((isset($shop->is_admin_gmap) && $shop->is_admin_gmap == 1) && (!empty($gmap_settings->is_gmap_key) && $gmap_settings->is_gmap_key == 1) && isset($shop->is_gmap) && $shop->is_gmap == 0) :
            $gmap = !empty(settings()['gmap_config']) ? json_decode(settings()['gmap_config']) : '';
            $gmap_key = $gmap->gmap_key;
        elseif (isset($shop->is_gmap) && $shop->is_gmap == 1 && !empty($shop->gmap_key)) :
            $gmap_key = $shop->gmap_key;
        else :
            $gmap_key = '';
        endif;

        return $gmap_key;
    }
}




if (!function_exists('tax')) {

    function tax($amount, $status)
    {
        $ci = get_instance();
        if ($status == "+") :
            return $amount . '% ' . lang('tax_included');
        else :
            return $amount . '% ' . lang('tax_excluded');
        endif;
    }
}



if (!function_exists('bg_loader')) {

    function bg_loader()
    {
        $ci = get_instance();
        return 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
    }
}

if (!function_exists('img_loader')) {

    function img_loader()
    {
        $ci = get_instance();
        return base_url('assets/frontend/images/background.gif');
        // return 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
    }
}


if (!function_exists('get_words')) {

    function get_words($sentence, $count = 5)
    {
        $ci = get_instance();
        preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
        return $matches[0];
    }
}

if (!function_exists('admin_currency_position')) {

    function admin_currency_position($amount)
    {
        $ci = get_instance();
        $settings = settings();
        $dir = isset($settings['currency_position']) ? $settings['currency_position'] : 1;
        $number_formats = isset($settings['number_formats']) ? $settings['number_formats'] : 1;
        if ($dir == 1) {
            return number_formats($amount, $number_formats) . '&nbsp;' . get_currency('icon');
        } else {
            return get_currency('icon') . '&nbsp;' . number_formats($amount, $number_formats);
        }
    }
}

if (!function_exists('currency_position')) {

    function currency_position($amount, $id)
    {
        $ci = get_instance();
        $shop = shop($id);
        $dir = $shop->currency_position ?? 1;
        if ($dir == 1) {
            return number_formats($amount, $shop->number_formats) . '&nbsp;' . $shop->icon;
        } else {
            return $shop->icon . '&nbsp;' . number_formats($amount, $shop->number_formats);
        }
    }
}

if (!function_exists('currency_format')) {

    function currency_format($amount, $id)
    {
        $ci = get_instance();
        $shop = shop($id);
        $dir = $shop->currency_position ?? 1;
        if ($dir == 1) {
            return $amount . ' ' . $shop->icon;
        } else {
            return $shop->icon . ' ' . $amount;
        }
    }
}





if (!function_exists('wh_currency_position')) {

    function wh_currency_position($amount, $id)
    {
        $ci = get_instance();
        $shop = shop($id);
        $dir = $shop->currency_position;
        if ($dir == 1) {
            return number_formats($amount, $shop->number_formats) . ' ' . $shop->icon;
        } else {
            return $shop->icon . ' ' . number_formats($amount, $shop->number_formats);
        }
    }
}

if (!function_exists('number_formats')) {
    function number_formats($amount, $number_formats)
    {
        $ci = get_instance();
        $type = $number_formats;
        if ($type == 0) {
            return round((float)$amount);
        } elseif ($type == 1) {
            return number_format((float)$amount, 2, '.', '');
        } elseif ($type == 2) {
            return number_format((float)$amount, 2, ',', '.');
        } elseif ($type == 4) {
            return number_format((float)$amount, 2, ',');
        } elseif ($type == 5) {
            return number_format((float)$amount, 0, ',', '.');
        } elseif ($type == 6) {
            return number_format((float)$amount, 3, '.', '');
        } else {
            $num = number_format((float)number($amount), 0, '.', '');
            $num = number_format((float)number($amount), 2);
            return $num;
        }
    }
}






if (!function_exists('get_icon')) {
    function get_icon($icon)
    {
        if (!empty($icon)) :
            $icon = explode('"', $icon);
            return $icon = $icon[1];
        else :
            return $icon = '';
        endif;
    }
}

if (!function_exists('cartIcon')) {
    function cartIcon()
    {
        return '<i class="icofont-cart-alt fa-2x"></i>';
    }
}

if (!function_exists('active')) {

    function active($type)
    {
        $ci = get_instance();
        $data = [];
        $settings = settings();
        if (isset($settings[$type]) && $settings[$type] == 1) {
            return 1;
        } else {
            return 0;
        }
    }
}


if (!function_exists('shop_active')) {

    function shop_active($type)
    {
        $ci = get_instance();
        $data = [];
        $settings = $ci->admin_m->my_vendor_info();
        if (isset($settings[$type]) && $settings[$type] == 1) {
            return 1;
        } else {
            return 0;
        }
    }
}


if (!function_exists('payment_methods')) {

    function payment_methods()
    {
        $ci = get_instance();
        $data = $ci->common_m->select_with_status('payment_method_list');
        if (overlay == 1) :
            return $data;
        else :
            return [];
        endif;
    }
}

if (!function_exists('admin_payment_methods')) {

    function admin_payment_methods()
    {
        $ci = get_instance();
        $data = $ci->common_m->select('payment_method_list');
        if (overlay == 1) :
            return $data;
        else :
            return [];
        endif;
    }
}

if (!function_exists('payment_method_list')) {

    function payment_method_list()
    {
        $ci = get_instance();
        $data = $ci->common_m->select_with_status('payment_method_list');
        return $data;
    }
}

if (!function_exists('get_domain')) {

    function get_domain($siteUrl)
    {
        $ci = get_instance();
        $siteUrl = preg_replace('#(^https?:\/\/(w{3}\.)?)|(\/$)#', '', $siteUrl);
        $siteUrl = str_replace('www.', '', $siteUrl);
        $siteUrl = str_replace('/.', '', $siteUrl);
        return $siteUrl . '/';
    }
}


if (!function_exists('resize_img')) {
    function resize_img($fullname, $width, $height, $dir = '')
    {
        if ($dir == '') {
            $dir = 'uploads/pwa/';
            $url = asset_url() . 'uploads/pwa/';
        } else {
            $dir = $dir;
            $url = $dir;
        }

        // Get the CodeIgniter super object
        $CI = &get_instance();
        // get src file's extension and file name
        $extension = pathinfo($fullname, PATHINFO_EXTENSION);
        $filename = pathinfo($fullname, PATHINFO_FILENAME);
        $image_org = $dir . $filename . "." . $extension;
        $image_thumb = $dir . $filename . "-" . $height . '_' . $width . "." . $extension;
        $image_returned = $url . $filename . "-" . $height . '_' . $width . "." . $extension;

        if (!file_exists($image_thumb)) {
            // LOAD LIBRARY
            $CI->load->library('image_lib');
            // CONFIGURE IMAGE LIBRARY
            $config['source_image'] = $image_org;
            $config['new_image'] = $image_thumb;
            $config['width'] = $width;
            $config['height'] = $height;
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();
        }
        return $image_returned;
    }
}


if (!function_exists('check_shop_open_status')) {

    function check_shop_open_status($shop_id)
    {
        $ci = get_instance();
        $time = $ci->common_m->get_single_appoinment(__week(), $shop_id);
        $shop_info =  shop($shop_id);
        $available_type =  isset($shop_info->available_type) ? $shop_info->available_type : "close";
        $jsonTime = !empty($time['time_config']) && isJson($time['time_config']) ? json_decode($time['time_config']) : '';
        $start_time = isset($time['start_time']) ? $time['start_time'] : '';
        $end_time =  isset($time['end_time']) ? $time['end_time'] : "";
        $now = get_times();

        if (!empty($jsonTime)) :
            $timeArray = $jsonTime;
        else :
            $timeArray = [];
        endif;

        if (isset($time['is_24']) && $time['is_24'] == 1) :
            if ($available_type == 'close') :
                if (isTimeWithinSlots($now, $timeArray)) {
                    $is_time = 1;
                } else {
                    $is_time = 0;
                }
            else :
                $is_time = 1;
            endif;

        else :
            if ($available_type == 'close') :
                if (!empty($jsonTime)) {
                    if (isTimeWithinSlots($now, $jsonTime)) {
                        $is_time = 1;
                    } else {
                        $is_time = 0;
                    }
                } else {
                    if (isBetween($start_time, $end_time, $now) == 1) {
                        $is_time = 1; //enable
                    } else {
                        $is_time = 0; //off
                    }
                }
            else :
                if (!empty($jsonTime)) {
                    if (isTimeWithinSlots($now, $jsonTime)) {
                        $is_time = 0;
                    } else {
                        $is_time = 1;
                    }
                } else {
                    if (isBetween($start_time, $end_time, $now) == 1) {
                        $is_time = 0; // off
                    } else {
                        $is_time = 1; //enable
                    }
                }
            endif;
        endif;

        return $is_time;
    }
}

if (!function_exists('isTimeWithinSlots')) {
    function isTimeWithinSlots($current_time, $time_slots)
    {

        if (!empty($time_slots)) :
            foreach ($time_slots as $time_slot) {
                if (isBetween($time_slot->start_time ?? '', $time_slot->end_time ?? '', $current_time)) {
                    return false; // Current time is within this time slot

                }
            }
        endif;


        return true; // Current time is not within any time slot
    }
}


if (!function_exists('isBetween')) {
    function isBetween($from, $till, $input)
    {
        $ci = &get_instance();
        //  echo $from.'- '. $till.'- '. $input. '<br>';
        if (!empty($from) && !empty($till)) {

            $f = DateTime::createFromFormat('!H:i', $from);
            $t = DateTime::createFromFormat('!H:i', $till);
            $i = DateTime::createFromFormat('!H:i', $input);

            // Check if DateTime::createFromFormat was successful
            if ($f === false || $t === false || $i === false) {
                return false;
            }

            if ($f > $t) {
                $t->modify('+1 day');
            }

            // Clone the $i object only if it's a DateTime object
            if ($i instanceof DateTime) {
                $iClone = clone $i;
                return ($f <= $i && $i <= $t) || ($f <= $iClone->modify('+1 day') && $iClone <= $t);
            }
        }

        return false;
    }
}





if (!function_exists('isLocalHost')) {

    function isLocalHost()
    {
        $localhost = array(
            '127.0.0.1',
            '::1'
        );

        return in_array($_SERVER['REMOTE_ADDR'], $localhost);
    }
}

if (!function_exists('payment_type')) {
    function payment_type($type = 'all')
    {
        $ci = &get_instance();
        $array = ['cash', 'stripe', 'others'];
        if (is_numeric($type)) :
            return $array[$type];
        else :
            return $array;
        endif;
    }
}


if (!function_exists('pos_payment_type')) {
    function pos_payment_type()
    {
        $ci = &get_instance();
        $array = ['cash', 'cheques', 'bank_transfer', 'pos', 'card', 'online', 'others'];
        return $array;
    }
}

if (!function_exists('cart')) {
    function cart($string)
    {
        $ci = &get_instance();
        return @$ci->session->userdata('cart')[$string];
    }
}

if (!function_exists('temp')) {
    function temp($string)
    {
        $ci = &get_instance();
        return @$ci->session->userdata('temp_data')[$string];
    }
}


if (!function_exists('customer')) {
    function customer()
    {
        $ci = &get_instance();
        return @$ci->session->userdata('cData');
    }
}

if (!function_exists('isEmpty')) {
    function isEmpty($val, $type = false)
    {
        return !empty($val) ? $val : ($type == 0 ? 0 : '');
    }
}



if (!function_exists('pos_config')) {
    function pos_config($id)
    {
        $ci = &get_instance();
        $u_settings = $ci->admin_m->get_user_settings($id);
        $data = !empty($u_settings['pos_config']) ? json_decode($u_settings['pos_config']) : '';
        return $data;
    }
}

if (!function_exists('s_slug')) {
    function s_slug($slug, $table)
    {
        $ci = &get_instance();
        $data = $ci->admin_m->single_select_by_slug($slug, $table);
        return @$data;
    }
}


if (!function_exists('is_pos')) {
    function is_pos()
    {
        $ci = &get_instance();
        $file = APPPATH . 'controllers/admin/Pos.php';
        if (file_exists($file)) {
            return 1;
        } else {
            return 0;
        }
    }
}

if (!function_exists('order_info')) {
    function order_info()
    {
        $ci = &get_instance();
        return @$ci->session->userdata('order_info');
    }
}


if (!function_exists('isJson')) {
    function isJson($string)
    {
        if (!empty($string)) :
            return ((is_string($string) &&
                (is_object(json_decode($string)) ||
                    is_array(json_decode($string))))) ? true : false;
        else :
            return '';
        endif;
    }
}


if (!function_exists('price_details')) {
    function price_details($shopId, $order_details = [])
    {
        $ci = &get_instance();
        $subtotal = $total = $shipping = $tax = 0;
        $tax_status = "+";
        $i = 1;
        $shop_info = shop($shopId);
        if (!empty(auth('is_paymentLink')) && auth('is_paymentLink') == 1) {
            $payment = auth('payment');
            $price = $payment['sub_total'] ?? 0;
            $tax_fee = $payment['tax_fee'] ?? 0;
        } else {
            foreach ($ci->cart->contents() as $key => $row) :

                $taxDetails[] = [
                    'percent' => $row['tax_fee'],
                    'price' => __taxCalc($row['price'], $row['tax_fee'], $row['tax_status']),
                    'tax_status' => $row['tax_status'] ?? '+',
                    'qty' => $row['qty'],
                ];

            endforeach;




            if ($shop_info->is_tax == 1 || (isset($i_info['is_item_tax']) && $i_info['is_item_tax'] == 1)) :
                $tax_fee = __tax($taxDetails)->total_tax_price;
                $price = $ci->cart->total() - $tax_fee;
                $is_item_tax = 1;
                $tax_percent = $shop_info->tax_fee;
                $tax_details = __tax($taxDetails)->details;
                $tax_status = '+';
            else :
                $price = $ci->cart->total();
                $tax_fee = __taxCalc($price, $shop_info->tax_fee, $shop_info->tax_status, $is_tax = 0);
                $tax_percent = $shop_info->tax_fee;
                $is_item_tax = 0;
                $tax_details = [];
                $tax_status = $shop_info->tax_status ?? '+';
                if (tax_type() == 'seperate') {
                    $price = $price;
                } else {
                    $price = $tax_status == '+' ? $price - $tax_fee : $price;
                }

            endif;
        }


        if (!empty($order_details)) {
            $i_info = $order_details;
        } else {
            if (!empty(auth('order_info'))) {
                $i_info = order_info();
            }
        }




        $subtotal = $price;




        if (!empty(cart('discount'))) :
            $discount = cart('discount');
        else :
            if (isset($i_info['discount']) && !empty($i_info['discount'])) {
                $discount = get_percent($subtotal, $i_info['discount'], $i_info['is_pos'] ?? 0);
            } else {
                $discount = 0;
            }
        endif;






        if (temp('is_cod') == true) :
            if (isset(shop($shopId)->is_area_delivery) && shop($shopId)->is_area_delivery == 1) :
                $shipping = @single(temp('cod')->shipping_area, 'delivery_area_list')->cost;
            else :
                $shipping = cart('shipping');
            endif;
        else :
            if (!empty(cart('shipping'))) :
                $shipping = cart('shipping');
            else :
                if (isset($i_info['delivery_charge']) && !empty($i_info['delivery_charge'])) {
                    $shipping = $i_info['delivery_charge'];
                } else {
                    $shipping = 0;
                };
            endif;
        endif;







        if (!empty(cart('coupon')->coupon_discount) && cart('coupon')->is_coupon == 1) :
            $get_percent = get_percent($subtotal, cart('coupon')->coupon_discount);
            $coupon_discount = $get_percent;
        else :
            if (isset($i_info['is_coupon']) && !empty($i_info['coupon_percent'])) {
                $coupon_discount =  get_percent($subtotal, $i_info['coupon_percent']);
                $coupon_percent = $i_info['coupon_percent'];
                $coupon_id = $i_info['coupon_id'];
            } else {
                $coupon_discount = 0;
            };
        endif;

        if (!empty(cart('service_charge'))) :
            $service_charge = cart('service_charge');
        else :
            if (isset($i_info['service_charge'])) {
                $service_charge = $i_info['service_charge'];
            } else {
                $service_charge = __service_charge($subtotal, $shopId)->price;;
            }
        endif;



        if (isset($i_info['tips']) && !empty($i_info['tips'])) {
            $tips = $i_info['tips'];
        } else {
            $tips = 0;
        };





        $grandTotal = get_total($subtotal, $shipping, $discount, $tax_fee, $coupon_discount, $tips, $tax_status, $service_charge);
        $arr = (object)[
            'shopId' => $shopId,
            'subtotal' => __numberFormat($subtotal, $shopId),
            'discount' => __numberFormat($discount, $shopId),
            'shipping' => __numberFormat($shipping, $shopId),
            'tax' => __numberFormat($tax_fee ?? 0, $shopId),
            'tax_fee' => __numberFormat($tax_fee ?? 0, $shopId),
            'tax_percent' => __numberFormat($tax_percent ?? 0, $shopId),
            'is_item_tax' => $is_item_tax ?? 0,
            'coupon_discount' => $coupon_discount,
            'grand_total' => __numberFormat($grandTotal, $shopId),
            'tax_details' => $tax_details ?? [],
            'tips' => __numberFormat($tips, $shopId),
            'service_charge' => __numberFormat($service_charge, $shopId),
        ];
        return $arr;
    }
}



if (!function_exists('order_st')) {
    function order_st($shop_id, $order_type = 1, $status = 0, $is_deliveried = 0)
    {
        $ci = &get_instance();
        $data = $ci->statistics_m->get_daily_order_statistics($shop_id, $order_type, $status, $is_deliveried);
        return @$data;
    }
}


if (!function_exists('is_new')) {
    function is_new($version)
    {
        $ci = &get_instance();
        $current_version = settings()['version'];
        if ($current_version == $version) {
            return '<span class="ab-position custom_badge danger-light-active">' . lang("new") . '</span>';
        }
    }
}

if (!function_exists('get_domain_name')) {
    function get_domain_name($url)
    {
        $ci = &get_instance();
        $url = 'https://' . $url;
        $parsed_url = parse_url($url);
        if (isset($parsed_url['host'])) :
            $host = $parsed_url['host'];
            $host_parts = explode('.', $host);
            $domain = @$host_parts[count($host_parts) - 2] . '.' . @$host_parts[count($host_parts) - 1];
            return $domain;
        else :
            return;
        endif;
    }
}



if (!function_exists('custom_domain')) {
    function custom_domain($url, $slug)
    {
        $ci = &get_instance();

        $subdomain_arr = explode('.', $url, 2); //creates the various parts
        $subdomain = $subdomain_arr[0];

        $domain = get_domain_name($url);

        $info = $ci->common_m->get_requested_username($subdomain, $domain);
        if (!empty($info)) {
            return $slug = $info->username;
        } else {
            return $slug = $slug;
        }
    }
}



if (!function_exists('check_domain')) {
    function check_domain($url)
    {
        $ci = &get_instance();
        $newUrl = 'https://' . $url;
        $newUrl = rtrim($newUrl, '/');
        $host = parse_url($newUrl, PHP_URL_HOST);
        $path = parse_url($newUrl, PHP_URL_PATH);
        if (substr_count($host, '.') > 1) {
            $subdomain_arr = explode('.', $url, 2);
            $subdomain_name = $subdomain_arr[0];
            return ['is_subdomain' => 1, 'is_domain' => 0, 'is_folder' => 0, 'url' => $subdomain_name, 'site_url' => $host . $path];
        } elseif (empty($path)) {
            return ['is_subdomain' => 0, 'is_domain' => 1, 'is_folder' => 0, 'url' => $host, 'site_url' => $host . $path];
        } else {
            return ['is_subdomain' => 0, 'is_domain' => 0, 'is_folder' => 1, 'url' => $path, 'site_url' => $host . $path];
        }
    }
}






if (!function_exists('pagadito')) {
    function pagadito($string)
    {
        $ci = &get_instance();
        return @$ci->session->userdata('pagadito_data')[$string];
    }
}


if (!function_exists('seo_settings')) {
    function seo_settings($id)
    {
        $ci = &get_instance();
        $user_settings = $ci->common_m->get_user_settings($id);
        $seo =  !empty($user_settings['seo_settings']) ? json_decode($user_settings['seo_settings'], true) : '';
        return $seo;
    }
}


if (!function_exists('extra_settings')) {
    function extra_settings($id)
    {
        $ci = &get_instance();
        $user_settings = $ci->common_m->get_user_settings($id);
        $extra =  !empty($user_settings['extra_config']) && isJson($user_settings['extra_config']) ? json_decode($user_settings['extra_config'], true) : '';
        return $extra;
    }
}

if (!function_exists('shop_languages')) {
    function shop_languages($id)
    {
        $ci = &get_instance();
        $extra =  extra_settings($id);
        $exlang = !empty($extra['languages']) && isJson($extra['languages']) ? json_decode($extra['languages']) : '';

        $activeLang = [];
        if (isset($extra['language_type']) && $extra['language_type'] == 'google') :
            $activeLang = get_languages();
        else :
            if (!empty($exlang)) :
                foreach (get_languages() as $key => $lan) {
                    if (isset($exlang) && !empty($exlang) &&  in_array($lan->slug, $exlang) == 1) :
                        $activeLang[] = $lan;
                    endif;
                }
            else :
                $activeLang = get_languages();
            endif;

        endif;

        return $activeLang;
    }
}

if (!function_exists('shop_default_language')) {
    function shop_default_language($id, $type = null)
    {
        $ci = &get_instance();
        $settings = settings();
        $extra =  extra_settings($id);
        $ln = !empty($extra['system_default_language']) ? $extra['system_default_language'] : $settings['language'];
        if ($type == null):
            if (empty(auth('vendor_lang'))) :
                $ci->session->set_userdata(['site_lang' => $ln, 'vendor_lang' => $ln, 'lang_vendor_id' => $id]);
                header("Refresh:0");
            endif;
        else:
            return $ln;
        endif;
    }
}

if (!function_exists('__shopLang')) {
    function __shopLang($id = '')
    {
        $ci = &get_instance();

        $id = !empty($id) ? $id : auth('id');
        $settings = settings();
        $extra =  extra_settings($id);
        $ln = !empty($extra['system_default_language']) ? $extra['system_default_language'] : $settings['language'];
        return $ln;
    }
}

if (!function_exists('glang')) {
    function glang($id)
    {
        $ci = &get_instance();
        $extra =  extra_settings($id);
        $glang = !empty($extra['glanguage']) && isJson($extra['glanguage']) ? json_decode($extra['glanguage']) : '';

        if (isset($extra['language_type']) && $extra['language_type'] == 'google') :
            if (!empty($glang)) :
                return ['is_glang' => 1, 'language' => $glang, 'dlanguage' => $extra['default_language']];
            endif;
        endif;
    }
}



if (!function_exists('orderId')) {
    function orderId($shopId = 0)
    {
        $ci = &get_instance();
        return date('Y') . random_string('numeric', 2) . $shopId . random_string('numeric', 2) . $shopId;
    }
}

if (!function_exists('pusher_config')) {
    function pusher_config($id = 0)
    {
        $ci = &get_instance();
        $is_admin = 0;
        if ($is_admin == 1 || $id == 0) :
            $settings = $ci->admin_m->get_settings();
            $pusher_config = isJson($settings['pusher_config']) ? json_decode($settings['pusher_config']) : '';
        else :
            if (!empty($id) && $id != 0) {
                $user_settings = $ci->common_m->get_user_settings_by_shop_id($id);
                $pusher_config = !empty($user_settings['pusher_config']) && isJson($user_settings['pusher_config']) ? json_decode($user_settings['pusher_config']) : '';
            } else {
                $settings = $ci->admin_m->get_settings();
                $pusher_config = !empty($user_settings['pusher_config']) && isJson($settings['pusher_config']) ? json_decode($settings['pusher_config']) : '';
            }
        endif;
        return $pusher_config;
    }
}


if (!function_exists('tips_config')) {
    function tips_config($id = 0)
    {
        $ci = &get_instance();
        $shop_info = shop($id);
        $is_tips = isJson($shop_info->tips_config) ? json_decode($shop_info->tips_config) : '';
        $tips_field_config = !empty($is_tips) && isJson($is_tips->tips_fields) ? json_decode($is_tips->tips_fields) : '';
        return (object)['is_tips' => $is_tips->is_tips ?? 0, 'tips_field_config' => $tips_field_config ?? ''];
    }
}


if (!function_exists('get_languages')) {
    function get_languages($id = 0)
    {
        $ci = &get_instance();
        $data = $ci->admin_m->get_languages();
        return $data;
    }
}


if (!function_exists('site_lang__')) {
    function site_lang__()
    {
        $ci = &get_instance();
        if (!empty(auth('site_lang')) && !empty(auth('lang_vendor_id'))):
            $data = !empty(auth('site_lang')) ? auth('site_lang') : st()->language;
        else:
            $data = !empty(auth('frontend_lang')) ? auth('frontend_lang') : st()->language;
        endif;

        return html_escape($data);
    }
}


if (!function_exists('site_lang')) {
    function site_lang()
    {
        $ci = &get_instance();

        // First check URL parameter
        $url_lang = $ci->input->get('lang', TRUE);
        if (!empty($url_lang)) {
            $ci->session->set_userdata('site_lang', $url_lang);
            return html_escape($url_lang);
        }

        // Check MY_Controller if applicable
        if ($ci instanceof MY_Controller && method_exists($ci, 'get_current_language')) {
            $controller_lang = $ci->get_current_language();
            if (!empty($controller_lang)) {
                return html_escape($controller_lang);
            }
        }

        // Then check session
        $session_lang = $ci->session->userdata('site_lang');
        if (!empty($session_lang)) {
            return html_escape($session_lang);
        }

        // Then check user's authenticated language preference
        if (function_exists('auth') && auth('is_login') && !empty(auth('site_lang'))) {
            return html_escape(auth('site_lang')) ?? st()->language;
        }

        // Finally fall back to default language
        return html_escape($ci->settings['language'] ?? 'english');
    }
}


if (!function_exists('multi_lang')) {
    function multi_lang($id, $cat_id)
    {
        $ci = &get_instance();
        if (isset(restaurant($id)->is_multi_lang) && restaurant($id)->is_multi_lang == 1) {
            return $cat_id['category_id'];
        } else {
            return $cat_id['id'];
        }
    }
}



if (!function_exists('xs_clean')) {
    function xs_clean($inputs)
    {
        $ci = &get_instance();
        $ci->load->helper('security');
        return $ci->system_model->xss_clean($inputs);
    }
}


if (!function_exists('avoid_xss')) {
    function avoid_xss($inputP)
    {
        $ci = &get_instance();
        return $ci->system_model->avoid_xss($inputP);
    }
}


if (!function_exists('mail_type')) {
    function mail_type($type = '')
    {
        $ci = &get_instance();
        $mailType = [
            'recovery_mail' => ['SITE_NAME', 'USERNAME', 'PASSWORD'],
            'contact_mail' => ['SITE_NAME', 'NAME', 'EMAIL', 'MESSAGE'],
            'resend_verify_mail' => ['SITE_NAME', 'USERNAME', 'LINK'],
            'email_verification_mail' => ['SITE_NAME', 'USERNAME', 'EMAIL', 'PASSWORD', 'PACKAGE_NAME', 'VERIFY_LINK'],
            'account_create_invoice' => ['SITE_NAME', 'USERNAME', 'PACKAGE_NAME', 'PRICE'],
            'new_user_mail' => ['SITE_NAME', 'USERNAME', 'EMAIL', 'PACKAGE_NAME'],
            'offline_payment_request_mail' => ['SITE_NAME', 'USERNAME', 'EMAIL', 'PACKAGE_NAME', 'PRICE', 'TXNID'],
            // 'new_user_create_mail_by_author'=>['SITE_NAME','USERNAME','EMAIL','PACKAGE_NAME','PASSWORD'],
            'send_payment_verified_email' => ['SITE_NAME', 'USERNAME', 'EMAIL', 'PAYMENT_METHOD', 'PAYMENT_DATE', 'TXNID', 'EXPIRE_DATE', 'PACKAGE_NAME', 'PRICE'],
            'expire_reminder_mail' => ['SITE_NAME', 'USERNAME', 'EMAIL', 'EXPIRE_DATE', 'REMAINING_DAYS'],
            'account_expire_mail' => ['SITE_NAME', 'USERNAME', 'EMAIL', 'EXPIRE_DATE'],
        ];
        if ($type == '') {
            return $mailType;
        } else {
            return !empty($mailType[$type]) ? $mailType[$type] : '';
        }
    }
}


if (!function_exists('create_email_msg')) {
    function create_email_msg($data, $msg)
    {
        $ci = get_instance();
        $find       = array_keys($data);
        $replace    = array_values($data);
        $new_msg = str_replace($find, $replace, $msg);
        if (!empty($new_msg)) {
            return str_replace(array('{', '}'), ' ', xs_clean($new_msg));;
        } else {
            return '';
        }
    }
}

if (!function_exists('product_limit')) {
    function product_limit($id)
    {
        $ci = get_instance();
        $settings = $ci->common_m->get_user_settings($id);
        $extra = !empty($settings['extra_config']) ? json_decode($settings['extra_config']) : '';
        return $item_peg = isset($extra->item_limit) ? $extra->item_limit : 8;
    }
}

if (!function_exists('netseasyUrl')) {
    function netseasyUrl($environment = '0')
    {
        if ($environment == '0') {
            $url = 'https://test.api.dibspayment.eu';
            $checkout = 'https://test.checkout.dibspayment.eu';
        } else {
            $url = 'https://api.dibspayment.eu';
            $checkout = 'https://checkout.dibspayment.eu';
        }
        return (object)['url' => $url, 'checkout' => $checkout];
    }
}


if (!function_exists('validUrl')) {
    function validUrl($siteUrl)
    {
        $siteUrl = preg_replace('#(^https?:\/\/(w{3}\.)?)|(\/$)#', '', $siteUrl);
        $siteUrl = str_replace('www.', '', $siteUrl);
        $siteUrl = str_replace('/.', '', $siteUrl);
        return $siteUrl;
    }
}


if (!function_exists('checkHttp')) {
    function checkHttp($siteUrl)
    {
        $url = parse_url(base_url());
        if (isset($url['scheme'])) {
            return $url['scheme'];
        } else {
            return;
        }
    }
}

if (!function_exists('is_image')) {
    function is_image($id)
    {
        $ci = get_instance();
        $is_img = $ci->admin_m->single_select_by_id($id, 'restaurant_list');
        if (isset($is_img['is_image']) && $is_img['is_image'] == 1) {
            return 'prevent-image';
        } else {
            return 0;
        }
    }
}

if (!function_exists('customer_phone')) {
    function customer_phone($phone, $dial_code)
    {
        if (empty($phone)) {
            return '';
        }



        if (strpos($dial_code, '+') !== false) {
            $dial_code = ltrim($dial_code, '+');
        } else {
            $dial_code = $dial_code;
        }


        if (substr($phone, 0, strlen($dial_code))) {
            $phone = ltrim($phone, $dial_code);
            $phone = $dial_code . $phone;
        } else {
            $phone = $dial_code . $phone;
        }

        return $phone;
    }
}


if (!function_exists('is_image')) {
    function is_image($id)
    {
        $ci = get_instance();
        $is_img = $ci->admin_m->single_select_by_id($id, 'restaurant_list');
        if (isset($is_img['is_image']) && $is_img['is_image'] == 1) {
            return 'prevent-image';
        } else {
            return 0;
        }
    }
}



if (!function_exists('__cart')) {
    function __cart()
    {
        $ci = get_instance();
        $cartItems = $ci->cart->contents();
        if (isset($cartItems) && !empty($cartItems)) {
            $cart_info = [];
            $cartQty = 0;
            foreach ($cartItems as $key => $shop_ids) {
                $cartQty += $shop_ids['qty'] ?? 0;
                $cart_info =  [
                    'shop_id' => $shop_ids['shop_id'] ?? 0,
                    'is_pos' => $shop_ids['is_pos'] ?? 0,
                    'qty' => $cartQty,
                ];
            }
        } else {
            $cart_info =  [
                'shop_id' => 0,
                'is_pos' => 0,
                'qty' => 0,
            ];
        }
        return (object) $cart_info;
    }
}


if (!function_exists('_ep')) {
    function _ep($data, $is_exit = 1)
    {
        $ci = get_instance();
        if ($is_exit == 1) {
            echo "<pre>";
            print_r($data);
            exit();
        } else {
            echo "<pre>";
            print_r($data);
        }
    }
}


if (!function_exists('glanguage')) {
    function glanguage()
    {
        $ci = get_instance();
        $jsonFile = APPPATH . 'third_party/language_list.json';
        if (file_exists($jsonFile)) {
            $jsonData = file_get_contents($jsonFile);
            return json_decode($jsonData);
        } else {
            return 'Language file not found.';
        }
    }
}
if (!function_exists('status')) {
    function status($data)
    {
        $ci = get_instance();
        switch ($data) {
            case 'pending':
                return 0;
                break;
            case ($data == 'accepted' || $data == 'approved'):
                return 1;
                break;

            case 'rejected':
                return 2;
                break;

            default:
                return 0;
                break;
        }
    }
}


if (!function_exists('order_action')) {
    function order_action($data)
    {
        $ci = get_instance();
        switch ($data) {
            case 0:
                return 'pending';
                break;
            case 1:
                return 'accept';
                break;

            case 2:
                return 'complete';
                break;

            case 3:
                return 'reject';
                break;

            default:
                return 0;
                break;
        }
    }
}


if (!function_exists('daterange')) {
    function daterange($date)
    {
        if (!empty($date)) {
            try {
                // Limpa o valor removendo o "+" se existir
                $clean_date = str_replace('+', '', $date);
                
                // Divide a string em duas datas
                $date_parts = explode('-', $clean_date);
                
                // Se tiver duas partes (início e fim do intervalo)
                if (count($date_parts) == 2) {
                    $start_date = trim($date_parts[0]);
                    $end_date = trim($date_parts[1]);
                    
                    // Tenta converter para objetos DateTime para manipulação
                    $start_dt = DateTime::createFromFormat('d M Y', $start_date);
                    $end_dt = DateTime::createFromFormat('d M Y', $end_date);
                    
                    // Se a conversão foi bem-sucedida, formata para pt-BR
                    if ($start_dt && $end_dt) {
                        $meses_pt = [
                            'Jan' => 'Jan', 'Feb' => 'Fev', 'Mar' => 'Mar', 'Apr' => 'Abr',
                            'May' => 'Mai', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ago',
                            'Sep' => 'Set', 'Oct' => 'Out', 'Nov' => 'Nov', 'Dec' => 'Dez'
                        ];
                        
                        // Formata a data inicial
                        $start_day = $start_dt->format('d');
                        $start_month_en = $start_dt->format('M');
                        $start_year = $start_dt->format('Y');
                        $start_month_pt = isset($meses_pt[$start_month_en]) ? $meses_pt[$start_month_en] : $start_month_en;
                        
                        // Formata a data final
                        $end_day = $end_dt->format('d');
                        $end_month_en = $end_dt->format('M');
                        $end_year = $end_dt->format('Y');
                        $end_month_pt = isset($meses_pt[$end_month_en]) ? $meses_pt[$end_month_en] : $end_month_en;
                        
                        // Retorna o formato pt-BR
                        return "{$start_day} {$start_month_pt} {$start_year} - {$end_day} {$end_month_pt} {$end_year}";
                    }
                }
                
                // Se não conseguir converter, retorna o valor original limpo
                return $clean_date;
            } catch (Exception $e) {
                return $date; // Em caso de erro, retorna a data original
            }
        }
        return '';
    }
}

if (!function_exists('languageDropdown')) {
    function languageDropdown($data, $is_prevent = false)
    {
        $ci = get_instance();
        $data = $ci->load->view('backend/products/language_dropdown.php', ['data' => $data, 'is_prevent' => $is_prevent]);
        return $data;
    }
}
if (!function_exists('get_reject_reson')) {
    function get_reject_reson($data)
    {
        $ci = get_instance();
        if (!empty($data) && isJson($data)) {
            $r = json_decode($data);
            $reject_msg = isset($r->reject_msg) && !empty($r->reject_msg) ? $r->reject_msg : '';
            if (is_array($r->reason_ids)) :
                $reason = $ci->admin_m->get_my_reject_reason($r->reason_ids);
                return (object) ['reason_list' => $reason, 'reject_msg' => $reject_msg];
            else :
                return (object) ['reason_list' => [], 'reject_msg' => $reject_msg];
            endif;
        } else {
            return (object) ['reason_list' => [], 'reject_msg' => ''];
        }
    }
}
if (!function_exists('uid')) {
    function uid()
    {
        $ci = get_instance();
        return time() . random_string('numeric', 3);
    }
}

if (!function_exists('whatsappMsg')) {
    function whatsappMsg($msg)
    {
        $ci = get_instance();
        $msg = str_replace('<br>', "\n", $msg);
        $msg = str_replace('<p>', "", $msg);

        return $msg;
    }
}

if (!function_exists('lang_slug')) {
    function lang_slug($slug)
    {
        $ci = get_instance();
        $ln = s_slug($slug, 'languages');
        return $ln->lang_name ?? 'English';
    }
}

if (!function_exists('imgRation')) {
    function imgRation($url)
    {
        $ci = get_instance();
        $ratio = 'square';


        // Check if the URL starts with HTTPS
        if (strpos($url, 'https://') === 0) {
            $url = 'http://' . substr($url, 8);  // Change to HTTP
        }

        if (!empty($url) &&  file_exists($url)) {
            list($height, $width) = getimagesize($url);  // Now using HTTP URL

            if ($width > $height) {
                $ratio = 'landscape';
            } elseif ($width == $height) {
                $ratio = 'square';
            } else {
                $ratio = 'portrait';
            }
        }

        return $ratio;
    }
}


if (!function_exists('actionType')) {
    function actionType($type)
    {
        $ci = get_instance();
        if ($type == 'create_order') :
            return lang('order') . ' ' . lang('create');
        elseif ($type == 'accept') :
            return lang('order') . ' ' . lang('accept');
        elseif ($type == 'complete') :
            return lang('order') . ' ' . lang('complete');
        elseif ($type == 'reject') :
            return lang('order') . ' ' . lang('reject');
        endif;
    }
}

if (!function_exists('extra_qty')) {
    function extra_qty($data, $extraId)
    {
        $ci = &get_instance();
        $data = !empty($data) && isJson($data) ? json_decode($data) : '';
        if (!empty($data)) {
            foreach ($data as $item) {
                if ($item->extra_id == $extraId) {
                    return $item->ex_qty ?? 1;
                }
            }
            return 1;
        }
    }
}

if (!function_exists('extraList')) {
    function extraList($extraId = '', $extra_qty = [], $item_id = 0, $shop_id = 0)
    {
        if (!empty($extraId) && isJson($extraId)) :
            $extraId = json_decode($extraId);
            $html = '<ul>';
            foreach ($extraId as $key => $ex) {
                $ex_qty = extra_qty($extra_qty, $ex);
                $ex_info = extras($ex, $item_id);
                $ex_name = $ex_info->ex_name ?? '';
                $ex_price = $ex_info->ex_price ?? 0;

                $exGrandTotal = $ex_qty * $ex_price;

                $html .= '<li>';
                $html .= '<span>';
                $html .= $ex_qty . ' x <span class="extraName">' . $ex_name . '</span> (' . $ex_price . ')';
                $html .= '</span>';
                $html .= ' = ';
                $html .= '<span class="priceTag">';
                $html .= currency_position($exGrandTotal, $shop_id);
                $html .= '</span>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        else :
            $html = '';
        endif;

        return $html;
    }
}

function whatsappExtra($extraId = '', $extra_qty = [], $item_id = 0, $shop_id = 0)
{
    $output = '';
    if (!empty($extraId) && isJson($extraId)) :
        $extraId = json_decode($extraId);
        foreach ($extraId as $key => $ex) {
            $ex_qty = extra_qty($extra_qty, $ex);
            $ex_info = extras($ex, $item_id);
            $ex_name = $ex_info->ex_name;
            $ex_price = $ex_info->ex_price;
            $ex_price_icon = wh_currency_position($ex_price, $shop_id);
            $exGrandTotal = $ex_qty * $ex_price;

            $output .= "  $ex_qty x $ex_price_icon \t$ex_name --- " . wh_currency_position($exGrandTotal, $shop_id) . "\n";
        }
    endif;
    return $output;
}



if (!function_exists('subcat')) {
    function subcat($id)
    {
        $ci = get_instance();

        $subcat = $ci->admin_m->single_select_by_id($id, 'sub_category_list');
        if (isset($subcat) && !empty($subcat['sub_category_name'])) {
            return $subcat['sub_category_name'];
        } else {
            return '';
        }
    }
}

if (!function_exists('generate_csv')) {
    function generate_csv($data, $title = 'template')
    {
        $ci = get_instance();
        $ci->load->helper('file');

        $csv_file = fopen('php://output', 'w');
        $header = $data;

        // Escreve o cabeçalho
        fputcsv($csv_file, $header);
        
        // Se for o template de cidades, adiciona algumas linhas de exemplo
        if ($title == 'city_names' && in_array('city_name', $data) && in_array('state', $data)) {
            // Exemplos para facilitar
            $examples = [
                ['São Paulo', 'SP'],
                ['Rio de Janeiro', 'RJ'],
                ['Belo Horizonte', 'MG']
            ];
            
            foreach ($examples as $example) {
                fputcsv($csv_file, $example);
            }
        }

        fclose($csv_file);
        $filename = str_slug($title) . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
    }
}
if (!function_exists('import_csv')) {
    function import_csv($data, $table, $static_columns = [])
    {
        $ci = get_instance();
        $ci->load->helper('file');

        $csvMimes = array('application/vnd.ms-excel', 'text/plain', 'text/csv', 'text/tsv');

        if (empty($_FILES['file']['name'])) {
            return "Nenhum arquivo foi enviado";
        }

        if (!in_array($_FILES['file']['type'], $csvMimes)) {
            return "Tipo de arquivo inválido. Por favor, use um arquivo CSV";
        }

        if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
            return "Falha no upload do arquivo";
        }

        // Inicia importação propriamente dita
        $content = file_get_contents($_FILES['file']['tmp_name']);
        
        // Detectar BOM UTF-8 e removê-lo
        $bom = pack('H*', 'EFBBBF');
        $content = preg_replace("/^$bom/", '', $content);
        
        // Salvar conteúdo em um arquivo temporário
        $temp_file = tempnam(sys_get_temp_dir(), 'csv_import');
        file_put_contents($temp_file, $content);
        
        // Abrir arquivo para leitura
        $csvFile = fopen($temp_file, 'r');
        
        // Ler cabeçalho
        $header = fgetcsv($csvFile);

        if ($header === false) {
            fclose($csvFile);
            unlink($temp_file);
            return "Cabeçalho não encontrado no arquivo CSV";
        }

        // Mapear as colunas do CSV para as colunas do banco de dados
        $column_names = $data;
        $column_mapping = array();
        
        foreach ($column_names as $column_name) {
            $index = array_search($column_name, $header);
            // Se não encontrar, tentar remover acentos e espaços
            if ($index === false) {
                $normalized_header = array_map(function($item) {
                    return strtolower(trim($item));
                }, $header);
                $index = array_search(strtolower(trim($column_name)), $normalized_header);
            }
            if ($index !== false) {
                $column_mapping[$column_name] = $index;
            }
        }

        if (empty($column_mapping)) {
            fclose($csvFile);
            unlink($temp_file);
            return "Nenhuma coluna válida encontrada. Seu arquivo CSV deve ter os cabeçalhos: " . implode(", ", $column_names);
        }

        // Adiciona created_at automaticamente
        $created_at = d_time();
        $csv_data = array();
        $row_count = 0;
        $error_rows = [];

        while (($row = fgetcsv($csvFile)) !== FALSE) {
            $row_count++;
            
            // Verificar se a linha tem dados suficientes
            if (count($row) < count($header)) {
                $error_rows[] = $row_count;
                continue; // Linha inválida, ignora
            }

            $row_data = array();
            foreach ($column_mapping as $db_column => $csv_index) {
                if (isset($row[$csv_index])) {
                    // Garantir que os dados sejam tratados corretamente
                    $value = $row[$csv_index];
                    // Converter para UTF-8 se necessário
                    if (!mb_check_encoding($value, 'UTF-8')) {
                        $value = mb_convert_encoding($value, 'UTF-8');
                    }
                    // Limpar dados
                    $value = trim($value);
                    $row_data[$db_column] = $value;
                }
            }

            // Adiciona colunas estáticas/valores padrão
            if (sizeof($static_columns) > 0) {
                foreach ($static_columns as $column_name => $value) {
                    $row_data[$column_name] = $value;
                }
            }

            // Adiciona created_at automaticamente
            $row_data['created_at'] = $created_at;

            if (!empty($row_data) && count($row_data) >= count($column_names)) {
                $csv_data[] = $row_data;
            } else {
                $error_rows[] = $row_count;
            }
        }
        
        fclose($csvFile);
        unlink($temp_file);

        if (empty($csv_data)) {
            return "Nenhum dado válido encontrado no arquivo. " . 
                   (count($error_rows) > 0 ? "Linhas com erro: " . implode(", ", $error_rows) : "");
        }

        try {
            $ci->db->insert_batch($table, $csv_data);
            return true;
        } catch (Exception $e) {
            return "Erro ao inserir dados: " . $e->getMessage();
        }
    }
}


if (!function_exists('__others')) {
    function __others($id)
    {
        $ci = &get_instance();
        $shop_info = $ci->admin_m->get_shop_info($id);
        $data = isset($shop_info->others_config) && !empty($shop_info->others_config) ? json_decode($shop_info->others_config) : '';
        return $data;
    }
}


if (!function_exists('__distance')) {
    function __distance($lat1, $lon1, $lat2, $lon2, $unit = 'km')
    {
        $earth_radius_km = 6371;
        $earth_radius_miles = 3959;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        if ($unit == 'miles') {
            $distance = $earth_radius_miles * $c;
        } else {
            $distance = $earth_radius_km * $c;
        }

        return $distance;
    }
}
if (!function_exists('is_alert')) {
    function is_alert()
    {
        return 1;
    }
}
if (!function_exists('change_name')) {
    function change_name($slug)
    {
        switch ($slug):
            case "welcome":
                return __('welcome_page');
            case "whatsapp":
                return __('whatsapp_order');
            case "order":
                return __('online_order');
            default:
                return !empty(__($slug)) ? __($slug) : $slug;
        endswitch;
    }
}



if (!function_exists('lang_url')) {
    function lang_url($uri = '')
    {
        $CI = &get_instance();

        // Get the base URL first
        $url = base_url($uri);

        // Get current language
        $language = '';
        if (isset($CI->current_language)) {
            $language = $CI->current_language;
        } else if ($CI->input->get('lang')) {
            $language = $CI->input->get('lang');
        } else {
            $language = 'english'; // default language
        }

        // Skip for assets
        if (preg_match('/\.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)(\?.*)?$/i', $uri)) {
            return $url;
        }

        // Add language parameter if not present
        if (strpos($url, 'lang=') === false) {
            $separator = (strpos($url, '?') === false) ? '?' : '&';
            $url .= $separator . 'lang=' . $language;
        }

        return $url;
    }
}

// Helper function to get current language
if (!function_exists('current_language')) {
    function current_language()
    {
        $CI = &get_instance();
        return $CI->current_language ?? $CI->input->get('lang') ?? 'en';
    }
}

if (!function_exists('url')) {
    function url($my_url)
    {
        $ci = &get_instance();
        $current_lang = $ci->input->get('lang') ?: '';

        $url = '';
        $slug = '';
        $get_values = '';

        // Check if the URL contains query parameters
        if (strpos($my_url, "?") !== false) {
            $parsed_url = parse_url($my_url);
            if (isset($parsed_url['path'])) {
                $path_without_query = $parsed_url['path'];
                $slug = basename($path_without_query);
                $get_values = $parsed_url['query'] ?? '';

                // Remove trailing slashes from the path
                $new_url = rtrim($path_without_query, "/");

                // Check the position of the last slash
                $last_slash_pos = strrpos($new_url, "/");
                if ($last_slash_pos !== false) {
                    $url = substr($new_url, 0, $last_slash_pos);
                } else {
                    $url = $new_url;
                }

                // Add language parameter if not present and current_lang is not empty
                if ($current_lang && strpos($get_values, 'lang=') === false) {
                    $get_values .= (empty($get_values) ? '' : '&') . 'lang=' . $current_lang;
                }
                $url .= '?' . $get_values;
            }
        } else {
            // If no query string, check the last slash
            $last_slash_pos = strrpos($my_url, "/");
            if ($last_slash_pos !== false) {
                $slug = substr($my_url, $last_slash_pos + 1);
                $url = substr($my_url, 0, $last_slash_pos);
            } else {
                $slug = $my_url;
                $url = '';
            }
        }

        // Handle custom domains
        if ($ci->db->table_exists('custom_domain_list')) {
            $info = $ci->common_m->get_domain_info($slug);
        } else {
            $info = [];
        }

        if (!empty($info) && ($info->is_domain == 1 || $info->is_subdomain == 1) && $info->status == 2 && $info->is_ready == 1) {
            $final_url = 'https://' . $info->url;
            if (!empty($url)) {
                $final_url .= '/' . $url;
            }
            if ($current_lang && strpos($final_url, 'lang=') === false) {
                $final_url .= '?lang=' . $current_lang;
            }
            return $final_url;
        } else {
            $base_url = base_url($my_url);
            if ($current_lang && strpos($base_url, 'lang=') === false) {
                $separator = (strpos($base_url, '?') !== false) ? '&' : '?';
                $base_url .= $separator . 'lang=' . $current_lang;
            }
            return $base_url;
        }
    }
}



if (!function_exists('__orderId')) {
    function __orderId($restaurant_id)
    {
        $CI = &get_instance();

        // Get current date components
        $year_last_two = date('y'); // Last two digits of the year
        $month = date('m');         // Current month
        $today = today();           // Current date
        $created_at = d_time();     // Current timestamp

        // Start transaction
        $CI->db->trans_start();

        try {
            // Fetch the current counter for today
            $CI->db->where('restaurant_id', $restaurant_id);
            $CI->db->where('DATE(created_at)', $today);
            $existing_counter = $CI->db->get('order_counters')->row();

            // Determine the next order number
            $next_order_number = $existing_counter ? ($existing_counter->order_number + 1) : 1;

            // Generate the initial order ID
            $order_id = $year_last_two . $month . $restaurant_id . str_pad($next_order_number, 3, '0', STR_PAD_LEFT);

            // Ensure the generated order ID is unique
            $CI->db->where('shop_id', $restaurant_id);
            $CI->db->where('uid', $order_id);

            while ($CI->db->get('order_user_list')->num_rows() > 0) {
                // If a duplicate is found, increment the counter and regenerate the order ID
                $next_order_number++;
                $order_id = $year_last_two . $month . $restaurant_id . str_pad($next_order_number, 3, '0', STR_PAD_LEFT);

                $CI->db->reset_query();
                $CI->db->where('shop_id', $restaurant_id);
                $CI->db->where('uid', $order_id);
            }

            // Update or insert the final counter number
            if ($existing_counter) {
                // Update the existing counter
                $CI->db->where('restaurant_id', $restaurant_id);
                $CI->db->where('DATE(created_at)', $today);
                $CI->db->update('order_counters', ['order_number' => $next_order_number]);
            } else {
                // Insert a new counter record
                $CI->db->insert('order_counters', [
                    'restaurant_id' => $restaurant_id,
                    'order_number' => $next_order_number,
                    'created_at' => $created_at
                ]);
            }

            // Commit the transaction
            $CI->db->trans_commit();

            return $order_id;
        } catch (Exception $e) {
            // Rollback the transaction on error
            $CI->db->trans_rollback();
            log_message('error', 'Error generating order ID: ' . $e->getMessage());
            throw $e;
        }
    }
}


if (!function_exists('__ctemp')) {
    function __ctemp($string, $tempName = 'temp_data')
    {
        $ci = &get_instance();
        $session_data = $ci->session->tempdata($tempName);
        if (isset($session_data[$string])) {
            return $session_data[$string];
        } else {
            return '';
        }
    }
}

if (!function_exists('get_time_format')) {
    function get_time_format($id = 0)
    {
        $type = $id != 0 ? shop($id)->time_format : 1;
        return $type == 1 ? '12h' : '24h';
    }
}
