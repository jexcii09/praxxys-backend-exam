@extends('layouts.admin-template')
 
@section('title', 'Categories')

<div id="app">
    <div class="main">
        <div class="sidebar-panel">
            <x-sidebar class="sidebar-component"/>
        </div>
        <div class="main-panel">
            <x-header/>
            <div class="container mt-5 pb-5">
                <category-list />
            </div>
        </div>
    </div>
</div>