<?php 

class TemplateController {
    function build_template(string $file_path) : Template {
        return new Template();
    }
}

class Template {

    private string $template;
    private string $file_path;

    public function __construct(string $file_path = "templates")
    {
        $this -> file_path = $file_path;
    }

    function render(string $template,array $values) : string {
        $this->template = file_get_contents($this->file_path . "/$template");
        self::insert_values($values);
        return $this->template;
    }
    
    function insert_values(array $values) : void {
        foreach ($values as $key => $value) {
            $this->insert_value($key, $value);
        }
    }

    function insert_value(string $key, string $value) : void {
        $this->template = str_replace('{{' . $key . '}}', $value, $this->template);
    }
}

