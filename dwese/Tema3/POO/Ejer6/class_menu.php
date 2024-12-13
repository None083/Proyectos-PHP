<?php
class Menu{

    private $enlaces = array();

    public function cargar($url, $nombre){
        $this->enlaces[$nombre] = $url;
    }

    public function vertical(){
        foreach ($this->enlaces as $nombre => $url) {
            echo "<p><a href='".$url."'>".$nombre."</a></p>";
        }
    }

    public function horizontal(){
        echo "<p>";
        foreach ($this->enlaces as $nombre => $url) {
            echo "<a href='".$url."'>".$nombre."</a> - ";
        }
        echo "</p>";
    }
}
?>