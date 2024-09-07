@extends('layout.template')

@section('sidebar')
    <!-- <x-menu-tree title="Pertemuan 2" icon="fas fa-tachometer-alt" :active="request()->is('pertemuan2/*')"> -->

        <x-menu-item title="Tracks" icon="fas fa-list" :href="route('crud-song.index')" :active="request()->routeIs('crud-song.index')">
        </x-menu-item>

        {{-- <x-menu-item title="Tambah Song" icon="fas fa-plus-circle" :href="route('crud-song.create')" :active="request()->routeIs('crud-song.create')">
        </x-menu-item> --}}

                
        <x-menu-item title="Artist" icon="fas fa-list" :href="route('crud-singer.tampil')" :active="request()->routeIs('crud-singer.tampil')">
        </x-menu-item>

        {{-- <x-menu-item title="Tambah Artist" icon="fas fa-plus-circle" :href="route('crud-singer.tambah')" :active="request()->routeIs('crud-singer.tambah')">
        </x-menu-item> --}}

        <x-menu-item title="Genre" icon="fas fa-list" :href="route('crud-genre.index')" :active="request()->routeIs('crud-genre.index')">
        </x-menu-item>
        {{-- 
        <x-menu-item title="Tambah Genre" icon="fas fa-plus-circle" :href="route('crud-genre.create')" :active="request()->routeIs('crud-genre.create')">
        </x-menu-item> --}}



        <x-menu-item title="Album" icon="fas fa-list" :href="route('temp')" :active="request()->routeIs('temp')">
        </x-menu-item>
        <x-menu-item title="Record Label" icon="fas fa-list" :href="route('temp')" :active="request()->routeIs('temp')">
        </x-menu-item>
        <x-menu-item title="Playlist" icon="fas fa-list" :href="route('temp')" :active="request()->routeIs('temp')">
        </x-menu-item>
        <x-menu-item title="Favorites" icon="fas fa-list" :href="route('temp')" :active="request()->routeIs('temp')">
        </x-menu-item>

    <!-- </x-menu-tree> -->
    <!-- {{-- <x-menu-item title="Adminlte" icon="fas fa-plus-circle" href="/adminlte/index.html" active=''> -->
    <!-- </x-menu-item> --}} -->
@endsection
