<?php
if(!defined('PLX_ROOT'))
    exit;

$article    = (($plxPlugin->getParam('article')   && $plxPlugin->getParam('article')   == 1)  ? ' checked="checked" ' : '');
$categorie  = (($plxPlugin->getParam('categorie') && $plxPlugin->getParam('categorie') == 1)  ? ' checked="checked" ' : '');
$statique   = (($plxPlugin->getParam('statique')  && $plxPlugin->getParam('statique')  == 1)  ? ' checked="checked" ' : '');
$theme      = (($plxPlugin->getParam('theme')     && $plxPlugin->getParam('theme')     == 1)  ? ' checked="checked" ' : '');
$comment    = (($plxPlugin->getParam('comment')   && $plxPlugin->getParam('comment')   == 1)  ? ' checked="checked" ' : '');
$affichage  = (($plxPlugin->getParam('affichage') && $plxPlugin->getParam('affichage') == 1)  ? ' checked="checked" ' : '');
$user       = (($plxPlugin->getParam('user')      && $plxPlugin->getParam('user')      == 1)  ? ' checked="checked" ' : '');
$profil     = (($plxPlugin->getParam('profil')    && $plxPlugin->getParam('profil')    == 1)  ? ' checked="checked" ' : '');


if(!empty($_POST)) {

    $plxPlugin->setParam('article',     ((isset($_POST['article'])      && $_POST['article'] == 1)      ? 1 : 0), 'numeric');
    $plxPlugin->setParam('categorie',   ((isset($_POST['categorie'])    && $_POST['categorie'] == 1)    ? 1 : 0), 'numeric');
    $plxPlugin->setParam('statique',    ((isset($_POST['statique'])     && $_POST['statique'] == 1)     ? 1 : 0), 'numeric');
    $plxPlugin->setParam('theme',       ((isset($_POST['theme'])        && $_POST['theme'] == 1)        ? 1 : 0), 'numeric');
    $plxPlugin->setParam('comment',     ((isset($_POST['comment'])      && $_POST['comment'] == 1)      ? 1 : 0), 'numeric');
    $plxPlugin->setParam('affichage',   ((isset($_POST['affichage'])    && $_POST['affichage'] == 1)    ? 1 : 0), 'numeric');
    $plxPlugin->setParam('user',        ((isset($_POST['user'])         && $_POST['user'] == 1)         ? 1 : 0), 'numeric');
    $plxPlugin->setParam('profil',      ((isset($_POST['profil'])       && $_POST['profil'] == 1)       ? 1 : 0), 'numeric');

    $plxPlugin->saveParams();
    header('Location: parametres_plugin.php?p=plxeditor');
    exit;

}
?>

<h2><?php $plxPlugin->lang('L_TITLE') ?></h2>

<p><?php $plxPlugin->lang('L_DESCRIPTION') ?></p>

<form action="parametres_plugin.php?p=plxeditor" method="post">
<br /><br />
    Pages où afficher l'éditeur : <br /><br />

    <input type="checkbox" name="article"   <?php echo $article;   ?> value="1" />      Edition article <br />
    <input type="checkbox" name="categorie" <?php echo $categorie; ?> value="1" />    Edition catégories <br />
    <input type="checkbox" name="statique"  <?php echo $statique;  ?> value="1" />     Edition des pages statiques <br />
    <input type="checkbox" name="theme"     <?php echo $theme;     ?> value="1" />        Editeur de thèmes <br />
    <input type="checkbox" name="comment"   <?php echo $comment;   ?> value="1" />      Edition de commentaires<br />
    <input type="checkbox" name="affichage" <?php echo $affichage; ?> value="1" />    Paramètre d'affichage <br />
    <input type="checkbox" name="user"      <?php echo $user;      ?> value="1" />         Edition des utilisateurs <br />
    <input type="checkbox" name="profil"    <?php echo $profil;    ?> value="1" />       Edition du profil <br />

    <br />
    <br />

    <input type="submit" name="submit" value="Enregistrer" />

</form>