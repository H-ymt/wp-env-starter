<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo("charset"); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?= vite_src_static("favicon.ico") ?>">
  <link rel="apple-touch-icon" href="<?= vite_src_static("apple-touch-icon.png") ?>">
  <link rel="stylesheet" href="<?= vite_src_css("app.scss") ?>">
  <?php wp_head(); ?>
</head>

<body data-type="<?= IS_TYPE ?>" <?php body_class(); ?>>
  <header>
    <nav aria-label="グローバルナビゲーション">
      <ul>
        <li><a href="<?= URL_HOME ?>">HOME</a></li>
        <li><a href="<?= URL_ABOUT ?>">ABOUT</a></li>
        <li><a href="<?= URL_ARCHIVE ?>">ARCHIVE</a></li>
        <li><a href="<?= URL_PRIVACY ?>">PRIVACY</a></li>
      </ul>
    </nav>
  </header>