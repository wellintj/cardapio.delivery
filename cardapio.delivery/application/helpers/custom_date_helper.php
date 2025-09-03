<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Helper de formatação de datas para português do Brasil
 * 
 * Este arquivo contém funções para formatar datas no padrão brasileiro (PT-BR).
 * Para usar a formatação correta em todo o sistema:
 * 
 * 1. Utilize a função format_custom_date() para formatar datas
 * 2. Exemplos de uso:
 *    - format_custom_date($data, 'd \d\e F \d\e Y') - Para exibir "12 de Janeiro de 2023"
 *    - format_custom_date($data, 'd/m/Y') - Para exibir "12/01/2023"
 *    - format_custom_date($data, 'H:i') - Para exibir horário "14:30"
 *    - format_custom_date($data, 'h:i a') - Para exibir horário com AM/PM "02:30 pm"
 * 
 * Funções auxiliares:
 * - get_month_name_pt() - Retorna o nome do mês em português
 * - get_month_short_name_pt() - Retorna o nome abreviado do mês em português
 * - get_day_name_pt() - Retorna o nome do dia da semana em português
 * - format_pt_date() - Formata uma data para o padrão DD/MM/YYYY
 */

if (!function_exists('format_custom_date')) {
    /**
     * Formata uma data em vários formatos, convertendo os meses para PT-BR.
     *
     * @param string $date A data de entrada (ex.: "2025-01-10", "10 January, 2025").
     * @param string $output_format O formato de saída desejado (padrão: 'd M Y H:i').
     * @param string $input_format Opcional: formato da data de entrada para parsing.
     * @return string Data formatada no formato de saída.
     */
    function format_custom_date($date, $output_format = 'd M Y H:i', $input_format = null) {
        // Meses traduzidos
        $months_en_to_pt = [
            'January' => 'Janeiro', 'February' => 'Fevereiro', 'March' => 'Março', 
            'April' => 'Abril', 'May' => 'Maio', 'June' => 'Junho',
            'July' => 'Julho', 'August' => 'Agosto', 'September' => 'Setembro', 
            'October' => 'Outubro', 'November' => 'Novembro', 'December' => 'Dezembro'
        ];

        // Meses abreviados traduzidos
        $months_short_en_to_pt = [
            'Jan' => 'Jan', 'Feb' => 'Fev', 'Mar' => 'Mar', 'Apr' => 'Abr', 
            'May' => 'Mai', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ago', 
            'Sep' => 'Set', 'Oct' => 'Out', 'Nov' => 'Nov', 'Dec' => 'Dez'
        ];

        // Dias da semana traduzidos
        $days_en_to_pt = [
            'Monday' => 'Segunda-feira', 'Tuesday' => 'Terça-feira', 'Wednesday' => 'Quarta-feira', 
            'Thursday' => 'Quinta-feira', 'Friday' => 'Sexta-feira', 'Saturday' => 'Sábado', 'Sunday' => 'Domingo'
        ];

        // Dias da semana abreviados traduzidos
        $days_short_en_to_pt = [
            'Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 
            'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb', 'Sun' => 'Dom'
        ];

        // AM/PM traduzidos
        $ampm_en_to_pt = [
            'am' => 'am', 'AM' => 'AM',  // Mantido mais comum usar AM mesmo em português
            'pm' => 'pm', 'PM' => 'PM'   // Mantido mais comum usar PM mesmo em português
        ];

        // Trata a string de data vazia ou inválida
        if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
            return '';
        }

        try {
            // Cria objeto DateTime a partir da string de data
            $date_obj = $input_format 
                      ? DateTime::createFromFormat($input_format, $date) 
                      : new DateTime($date);

            if (!$date_obj) {
                return $date; // Se não conseguir converter, retorna a string original
            }

            // Formata a data no formato desejado
            $formatted_date = $date_obj->format($output_format);

            // Substitui os meses ingleses por portugueses
            foreach ($months_en_to_pt as $en => $pt) {
                $formatted_date = str_replace($en, $pt, $formatted_date);
            }

            // Substitui os meses abreviados ingleses por portugueses
            foreach ($months_short_en_to_pt as $en => $pt) {
                $formatted_date = str_replace($en, $pt, $formatted_date);
            }

            // Substitui os dias da semana ingleses por portugueses
            foreach ($days_en_to_pt as $en => $pt) {
                $formatted_date = str_replace($en, $pt, $formatted_date);
            }

            // Substitui os dias da semana abreviados ingleses por portugueses
            foreach ($days_short_en_to_pt as $en => $pt) {
                $formatted_date = str_replace($en, $pt, $formatted_date);
            }

            // Substitui AM/PM por versões em português
            foreach ($ampm_en_to_pt as $en => $pt) {
                $formatted_date = str_replace($en, $pt, $formatted_date);
            }

            return $formatted_date;
        } catch (Exception $e) {
            // Em caso de erro, retorna a string original
            return $date;
        }
    }
}

/**
 * Funções auxiliares para formatar tempo
 */
if (!function_exists('get_month_name_pt')) {
    /**
     * Retorna o nome do mês em português
     */
    function get_month_name_pt($month_number) {
        $months = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 
            4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
            7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 
            10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];
        
        return isset($months[$month_number]) ? $months[$month_number] : '';
    }
}

if (!function_exists('get_month_short_name_pt')) {
    /**
     * Retorna o nome abreviado do mês em português
     */
    function get_month_short_name_pt($month_number) {
        $months = [
            1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 
            4 => 'Abr', 5 => 'Mai', 6 => 'Jun',
            7 => 'Jul', 8 => 'Ago', 9 => 'Set', 
            10 => 'Out', 11 => 'Nov', 12 => 'Dez'
        ];
        
        return isset($months[$month_number]) ? $months[$month_number] : '';
    }
}

if (!function_exists('get_day_name_pt')) {
    /**
     * Retorna o nome do dia da semana em português
     */
    function get_day_name_pt($day_number) {
        $days = [
            0 => 'Domingo', 1 => 'Segunda-feira', 2 => 'Terça-feira', 
            3 => 'Quarta-feira', 4 => 'Quinta-feira', 5 => 'Sexta-feira', 6 => 'Sábado'
        ];
        
        return isset($days[$day_number]) ? $days[$day_number] : '';
    }
}

if (!function_exists('format_pt_date')) {
    /**
     * Formata uma data padrão para o formato brasileiro (DD/MM/YYYY)
     */
    function format_pt_date($date) {
        if (empty($date)) return '';
        
        $date_obj = new DateTime($date);
        return $date_obj->format('d/m/Y');
    }
}

if (!function_exists('format_date_ptbr')) {
    /**
     * Formata uma data no padrão brasileiro (DD/MM/YYYY)
     * 
     * @param string $date A data a ser formatada
     * @param bool $with_time Se deve incluir o horário (default: false)
     * @return string Data formatada
     */
    function format_date_ptbr($date, $with_time = false) {
        if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
            return '';
        }
        
        try {
            $datetime = new DateTime($date);
            if ($with_time) {
                return $datetime->format('d/m/Y H:i');
            } else {
                return $datetime->format('d/m/Y');
            }
        } catch (Exception $e) {
            return $date;
        }
    }
}

if (!function_exists('format_date_extensive')) {
    /**
     * Formata uma data por extenso em português (ex: 15 de Janeiro de 2025)
     * 
     * @param string $date A data a ser formatada
     * @return string Data formatada por extenso
     */
    function format_date_extensive($date) {
        return format_custom_date($date, 'd \d\e F \d\e Y');
    }
}

if (!function_exists('format_month_year')) {
    /**
     * Formata uma data mostrando apenas mês e ano em português
     * 
     * @param string $date A data a ser formatada
     * @return string Mês e ano formatados
     */
    function format_month_year($date) {
        return format_custom_date($date, 'F \d\e Y');
    }
}

if (!function_exists('format_time')) {
    /**
     * Formata apenas o horário de uma data
     * 
     * @param string $date A data contendo o horário
     * @return string Horário formatado
     */
    function format_time($date) {
        if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
            return '';
        }
        
        try {
            $datetime = new DateTime($date);
            return $datetime->format('H:i');
        } catch (Exception $e) {
            return $date;
        }
    }
}

if (!function_exists('date_show_ptbr')) {
    /**
     * Converte uma data do formato Y-m-d (banco) para formato brasileiro d/m/Y (exibição)
     * sem alterar o banco de dados
     * 
     * @param string $date A data no formato Y-m-d
     * @return string A data no formato d/m/Y
     */
    function date_show_ptbr($date) {
        if (empty($date) || $date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
            return '';
        }
        
        try {
            $datetime = new DateTime($date);
            return $datetime->format('d/m/Y');
        } catch (Exception $e) {
            return $date;
        }
    }
}

if (!function_exists('date_to_db')) {
    /**
     * Converte uma data do formato brasileiro d/m/Y para formato Y-m-d do banco
     * 
     * @param string $date A data no formato d/m/Y
     * @return string A data no formato Y-m-d
     */
    function date_to_db($date) {
        if (empty($date)) {
            return '';
        }
        
        // Verifica se já está no formato do banco
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }
        
        // Converte do formato brasileiro para o formato do banco
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            $parts = explode('/', $date);
            return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }
        
        // Último recurso: tenta usar strtotime
        try {
            return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
        } catch (Exception $e) {
            return $date;
        }
    }
}

// Configuração global do locale para português do Brasil
// Esta linha assegura que funções nativas do PHP como strftime
// usem o formato brasileiro quando possível
setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR', 'pt-BR', 'portuguese');

// Configurar a zona de tempo para o Brasil (opcional)
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('America/Sao_Paulo');
}
