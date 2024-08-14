<?php 

class TemplateController {
    function build_template(string $file_path) : Template {
        return new Template();
    }
}

class Template {

    private string $template;
    private string $file_path;

    public function __construct(string $file_path = 'templates')
    {
        $this -> file_path = $file_path;
    }
    /* Il build estrae il file e usa insert_values();*/
    function render(string $template) : string {
        $this->template = file_get_contents($this->file_path . "/$template");
        return $this->template;
    }
    /* Utilizza insert_value() per inserire il singolo elemento */
    function insert_values(array $values) : void {
        foreach ($values as $id => $value) {
            $this->insert_value($id, $value);
        }
    }

    function insert_value(string $value) : void {
        $this->template = str_replace('{{' . $value . '}}', $value, $this->template);
    }
}

?>