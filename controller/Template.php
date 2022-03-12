<?php

/** 
 * Template class to generate views
 * 
 * @author Roiner Adrianza <roineradrianzap@gmail.com>
 * 
 * @version Release: 1.0.0 
 * 
 * @access public
 */
class Template
{
    private $content;

    /** 
     * Construct method to generate the view
     * 
     * @param string $path route to the view file
     * @param array  $data data sent to be converted to vars into the template
     * 
     * @return void template generated
     * 
     * @access public
     */
    function __construct($path, $data = [])
    {
        extract($data);
        ob_start();
        include('views/' . $path . ".php");
        $this->content = ob_get_clean();
    }

    public function __toString()
    {
        return $this->content;
    }

    /** 
     * Admin menu tabs
     * 
     * @return array admin tabs
     * 
     * @access public
     */
    static function admin_menu_tabs()
    {
        $tabs = [
            'tabs' => [
                ['name' => 'Escritorio', 'icon' => 'mdi-view-dashboard', 'url' => 'dashboard'],
                ['name' => 'SEO', 'icon' => 'mdi-search-web', 'url' => 'seo'],
                ['name' => 'Foro', 'icon' => 'mdi-post', 'url' => 'forum'],
                ['name' => 'Medios', 'icon' => 'mdi-image-multiple', 'url' => 'library'],
                ['name' => 'Cursos', 'icon' => 'mdi-library', 'url' => 'courses'],
                ['name' => 'Pagos', 'icon' => 'mdi-credit-card-outline', 'url' => 'payments'],
                ['name' => 'Cupones', 'icon' => 'mdi-ticket-percent', 'url' => 'coupons'],
                ['name' => 'Calendario', 'icon' => 'mdi-calendar', 'url' => 'calendar'],
                ['name' => 'Correos automatizados', 'icon' => 'mdi-email', 'url' => 'email-messages'],
                ['name' => 'Usuarios', 'icon' => 'mdi-account-group', 'url' => 'users'],
                ['name' => 'Estadísticas de Ventas', 'icon' => 'mdi-graph', 'url' => 'sales'],
            ]
        ];
        return $tabs;
    }
}
