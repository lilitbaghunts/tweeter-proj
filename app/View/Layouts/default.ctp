<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$title_for_layout = 'Tweeter';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $title_for_layout ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('bootstrap');
        echo $this->Html->css('mystyle');

        echo $this->Html->script('jquery.min');
        echo $this->Html->script('bootstrap.min');

        echo $this->Html->script('jquery-ui-1.10.2.custom.min');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div id="header">
            <?php echo $this->element('header'); ?>
            <h1><?php //echo $this->Html->link($cakeDescription, 'http://cakephp.org');      ?></h1>
        </div>
        <div id="container">


            <div id="content">

                <?php echo $this->fetch('content'); ?>

                <?php echo $this->Session->flash(); ?>
            </div>
            <div id="footer">
                <?php echo $this->element('footer'); ?>
            </div>         
        </div>
        <?php // echo $this->element('sql_dump'); ?>
    </body>
</html>
