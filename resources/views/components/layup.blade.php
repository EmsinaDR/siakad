<!DOCTYPE html>
<html lang="en">
<?php
// session_start();
// $_SESSION['titleweb'] = 'Ata Devas';
// $_SESSION['judul'] = $title;
// $_SESSION['user'] = 'Dany Rospeta, S.Pd';
// $_SESSION['rool'] = 'Administrator';
// $member = 'pro';
?>

<!-- Data Header -->
<link rel="icon" type="image/x-icon" href="img/myicon.ico">
<x-property-header>{{ $slot }}</x-property-header>
<!-- / Data Header -->

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60" />
        </div>

        <x-header-menu>{{ $slot }}</x-header-menu>

        <!-- Main Sidebar Container -->

        @if ($member == 'gold')
        <x-right-navbar-gold>{{ $slot }}</x-right-navbar-gold>
        @elseif($member == 'pro')
        <x-right-navbar-pro>{{ $slot }}</x-right-navbar-pro>
        @endif
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {{-- <x-content-header>{{ $parent }}{{ $root }}</x-content-header> --}}
            <x-content-header>{{ $breadcrumb }}</x-content-header>

            {{-- <x-content-header>{{ $root }}</x-content-header> --}}
            {{-- <x-content-header>{{dd($title)}}</x-content-header> --}}

            <!-- Main content -->
