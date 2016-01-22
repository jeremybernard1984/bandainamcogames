<?php
namespace Core\HTML;
class BootstrapForm extends Form{

    /**
     * @param $html string Code HTML à entourer
     * @return string
     */

    protected function surround($html){
        return $html;
    }

    /**
     * @param $name string
     * @param $label
     * @param array $options
     * @return string
     */
    public function input($name, $label, $options = []){
        $choixOui = '';
        $choixNon = '';
        $type = isset($options['type']) ? $options['type'] : 'text';


            $label = '<label>' . $label . '</label>';


        if($type === 'textarea'){
            $input = '<textarea id="CKeditor_' . $name . '" name="' . $name . '" class="form-control">' . $this->getValue($name) . '</textarea>';
        }else if ($type === 'checkbox'){
            $checked = '';
            if($this->getValue($name) != ""){
                $checked = ' checked = "checked"';
            }
            $input = '<input type="' . $type . '" name="' . $name . '" class="form-control"' . $checked . '/>';
        }else if ($type === 'hidden') {
                $input = '<input type="' . $type . '" name="' . $name . '" value="EU" class="form-control"/>';
        }else if ($type === 'number'){
            $input = '<input type="' . $type . '" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control" min="0" max="99">';
        }else if ($type === 'text'){
            $input = '<input type="' . $type . '" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">';
        }else if ($type === 'radio'){
            if($this->getValue($name) == "1"){
                $choixOui = ' checked = "checked"';
            }else{
                $choixNon = ' checked = "checked"';
            }
            $input = '<label style="float: left;margin-right: 15px">Online visible:</label>';
            $input .= '<input style="float:left;" type="' . $type . '" value="1" name="' . $name . '" class="form-radio" id="oui"' . $choixOui . ' /> <label style="float:left;" for="oui">Oui</label>';
            $input .= '<input style="float:left;margin-left:15px;" type="' . $type . '" value="0" name="' . $name . '" class="form-radio" id="non"' . $choixNon . ' /> <label style="float:left;" for="non">Non</label>';
        }else if ($type === 'file'){
            $input = '<span style="background: #e1e1e8;display: block;margin-bottom:8px;"><label for="' . $name . '_delete" style="color: #d9534f;font-size: 12px;cursor:pointer;">Delete</label> <input type="checkbox" id="' . $name . '_delete" name="' . $name . '_delete"></span>';
            $input .= '<input type="' . $type . '" name="' . $name . '_img" value="" multiple = "multiple" >';
            $input .= '<input type="hidden" name="' . $name . '" value="' . $this->getValue($name) . '">';
        }else if ($type === 'datepicker'){
            $date=$this->getValue($name);
            if ($date=="01-01-1970" || $date==""){
                $date ="";
            }else{
                $date = date('d-m-Y', strtotime($date));
            }
            $input = '<input type="text" name="' . $name . '" value="' . $date . '" class="form-control" id="datepicker" placeholder="click to show datepicker">';
        }else{
            $input = '<input type="' . $type . '" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">';
        }
        return $this->surround($label . $input);
    }

    public function select($name, $label, $options){

        $label = '<label>' . $label . '</label>';
        $input = '<select class="form-control" name="' . $name . '">';
        foreach($options as $k => $v){
            $attributes = '';
            if($k == $this->getValue($name)){

                $attributes = ' selected';
            }
            $input .= "<option value='".$k."'$attributes>".$v."</option>";
        }
        $input .= '</select>';
        return $this->surround($label . $input);
    }

    public function checkbox($name, $options){
        $input = '';
            foreach($options as $k => $v){
                $input .= '<label class="btn btn-default">
                <input type="checkbox" id="'.$v.'" name="'.$name.'" value="'.$k.'" autocomplete="off">
                <img src="images/flags/32/'.$k.'.png"/></label>';
            }
        return $this->surround($input);
    }

    public function checkbox2($name, $options, $optionsCheck){
        if ($optionsCheck == ""){
            $my_var= array("0");
        }else{
            $my_var = [];
            if(isset($optionsCheck)){
                foreach ($optionsCheck as $opt) {
                    array_push($my_var, $opt->id_platform);
                }
            }
        }
        $input = '';
            foreach($options as $k => $v){
                $k = (string)$k;
                if (in_array($k, $my_var, TRUE))
                {
                    $attributes = "active";
                    $attributes2 = "checked = 'checked'";
                }else{
                    // PAr default les boutons sont cliqués ?????? POUR plus tard
                    $attributes = "";
                    $attributes2 = "";
                }
                $input .= '<label class="btn btn-default '. $attributes. '" style="width: 25%;font-size:12px">
                <input type="checkbox" id="'.$v.'" name="'.$name.'" value="'.$k.'" autocomplete="off" '. $attributes2. '>'
                .$v.'</label>';
            }
        return $this->surround($input);
    }


    /**
     * @return string
     */
    public function submit(){
        return $this->surround('<button type="submit" class="btn btn-primary">Envoyer</button>');
    }
}