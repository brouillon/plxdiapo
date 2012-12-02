<?php
/**
 * Plugin plxEditor
 *
 * @package PLX
 * @version 1.0 beta 1
 * @date    01/07/2011
 * @author  Stephane F
 **/
class plxdiapo extends plxPlugin {

    /**
     * Constructeur de la classe
     *
     * @param   default_lang    langue par défaut utilisée par PluXml
     * @return  null
     * @author  Stephane F
     **/
    public function __construct($default_lang) {

        # Appel du constructeur de la classe plxPlugin (obligatoire)
        parent::__construct($default_lang);

        # droits pour accèder à la page config.php du plugin
        $this->setConfigProfil(PROFIL_ADMIN);

        # Déclarations des hooks
        $this->addHook('plxEditorMediasEndHead', 'plxEditorMediasEndHead');
        $this->addHook('plxEditorMediasEndBody', 'plxEditorMediasEndBody');
        $this->addHook('ThemeEndHead',           'ThemeEndHead');
        $this->addHook('ThemeEndBody',           'ThemeEndBody');

        $this->loadParams();

    }

    #----------

    /**
     * Méthode appelé lors du préview d'un article: conversion des liens des images et des documents
     *
     * @return  stdio
     * @author  Stephane F
     **/
    public function plxEditorMediasEndHead() {

        echo "
            <script>
                function formatHTML(p_href, p_src, type) {
                    var p_title = document.getElementById('p_title') ? ' title=\"'+document.getElementById('p_title').value+'\"' : ''; // not implemented yet
                    var p_rel = document.getElementById('p_rel') ? ' rel=\"'+document.getElementById('p_rel').value+'\"' : ''; // not implemented yet
                    var p_class = document.getElementById('p_class') ? ' class=\"'+document.getElementById('p_class').value+'\"' : ''; // not implemented yet
                    var alignStart ='';
                    var alignEnd = '';
                    var alignment = document.forms[1].alignment;
                    if(alignment!=undefined || alignment!=null) {
                        for(var i = 0; i < 4; i++) {
                            if(alignment[i].checked && alignment[i].value!='none') {
                                if(alignment[i].value=='center') {
                                    alignStart = '<div style=\"text-align:center\">';
                                } else {
                                    alignStart = '<div style=\"float:'+alignment[i].value+'\">';
                                }
                                alignEnd = '</div> ';
                                break;
                            }
                        }
                    }
                    if(type=='1') {
                        if(p_src!='') {
                            return alignStart+'<a href=\"'+p_href+'\"'+p_title+p_class+p_rel+'><img src=\"'+p_src+'\" alt=\"\" /></a>'+alignEnd;
                        } else {
                            return alignStart+'<img src=\"'+p_href+'\" alt=\"\" />'+alignEnd;
                        }
                    }
                    else if (type=='2') {

                        return alignStart+'<a href=\"'+p_href+'\" class=\"diaporama\"><img src=\"'+p_src+'\" alt=\"\" /></a>'+alignEnd;

                    }
                    else {
                        return alignStart+'<a href=\"'+p_href+'\"'+p_title+p_rel+'>'+basename(p_href)+'</a>'+alignEnd;
                    }

                }

                function addDiapoLink() {

                    var editor = document.location.search.split('&')[0].split('=')[1];

                    var rows = document.getElementsByTagName(\"tr\");

                    if (editor && rows && rows[1])
                    {

                        var l = rows.length;
                        var i;
                        var img;

                        for (i = 1; i < l;i++) {

                            if (rows[i].childNodes[1] && rows[i].childNodes[2])
                            {
                                if (rows[i].childNodes[1].childNodes[0])
                                {
                                    img = rows[i].childNodes[1].childNodes[0].href;
                                    tb = img.substr(0, img.lastIndexOf(\".\")) + '.tb' + img.substr(img.lastIndexOf(\".\"));
                                }
                                rows[i].childNodes[2].innerHTML = rows[i].childNodes[2].innerHTML + '<br /><a onclick=\"window.opener.' + editor + '.execCommand(\'inserthtml\', formatHTML(\'' + img + '\', \'' + tb + '\', \'2\'));self.close();return false;\" title=\"\" href=\"javascript:void(0)\">Diaporama</a>';
                            }

                        }

                    }

                }

            </script>";

    }



    /**
     * Méthode du hook plxEditorMediasEndBody
     *
     * @return  stdio
     * @author  Stephane F
     **/
    public function plxEditorMediasEndBody() {

        echo "<script type=\"text/javascript\">
                    addDiapoLink();
                </script>";

    }

    /**
     * Méthode du hook AdminFootEndBody
     *
     * @return  stdio
     * @author  Stephane F
     **/
    public function ThemeEndHead() {

        global $plxAdmin, $plxShow;

        echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>';
        echo '<script src="plugins/plxdiapo/js/reflection.js"></script>';
        echo '<script src="plugins/plxdiapo/js/colorbox/jquery.colorbox.js"></script>';
        echo '<link rel="stylesheet" type="text/css" href="plugins/plxdiapo/js/colorbox/colorbox.css" media="screen" />';

    }

    /**
     * Méthode du hook AdminFootEndBody
     *
     * @return  stdio
     * @author  Stephane F
     **/
    public function ThemeEndBody() {


        echo '
        <script type="text/javascript">

                var xhr = [];

                var arrA = $(".diaporama");
                var len = arrA.length;

                for (var i = 0; i < len; i++)
                {

                    try {  xhr[i] = new ActiveXObject("Msxml2.XMLHTTP");   }
                    catch (e)
                    {
                        try {   xhr[i] = new ActiveXObject("Microsoft.XMLHTTP");    }
                        catch (e2)
                        {
                            try {  xhr[i] = new XMLHttpRequest();     }
                            catch (e3) {  xhr[i] = false;   }
                        }
                    }

                    xhr[i].onreadystatechange  = function()
                    {

                        if(this.readyState  == 4)
                        {

                            if(this.status  == 200)
                            {

                                var response, a, img;

                                try {
                                    response = eval(this.responseText);
                                } catch(e) {}

                                if (response) {

                                    for (var i = 0; i < response.length; i++)
                                    {

                                        a = document.createElement("a");
                                        a.href = response[i];
                                        a.rel = "modal" + this.cpt;
                                        a.style.display = "none";

                                        img = document.createElement("img");
                                        img.src = response[i];

                                        a.appendChild(img);

                                        this.element.parentNode.insertBefore(a, this.element.nextSibling);

                                    }

                                    this.element.rel = "modal" + this.cpt;
                                    this.element.firstChild.className = "myreflect";

                                    if (this.cpt + 1 == this.len)
                                    {

                                        while (this.len != 0)
                                        {

                                            this.len--;
                                            $("a[rel=\'modal" + this.len + "\']").colorbox({current:"image {current} sur {total}"});
                                            $(".myreflect").reflect({height:62});

                                        }

                                    }

                                }

                            }

                        }

                    };

                    xhr[i].element = arrA[i];
                    xhr[i].cpt = i;
                    xhr[i].len = len;
                    xhr[i].open("GET", "plugins/plxdiapo/ajax.php?image=" + arrA[i].href,  true);
                    xhr[i].send(null);

                }

        </script>
                ';

    }

}
?>