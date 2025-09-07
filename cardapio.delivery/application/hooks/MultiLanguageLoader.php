<?php
class MultiLanguageLoader
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function initialize()
    {
        // Get language from URL
        $url_lang = $this->CI->input->get('lang');
        if ($url_lang) {
            // If URL has language parameter, load that language
            $this->CI->lang->load('content', $url_lang);
        }
    }

    
}
