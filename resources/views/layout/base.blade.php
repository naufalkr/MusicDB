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

        <!-- <x-menu-item title="Genre" icon="fas fa-list" :href="route('crud-genre.index')" :active="request()->routeIs('crud-genre.index')">
        </x-menu-item>
        {{-- 
        <x-menu-item title="Tambah Genre" icon="fas fa-plus-circle" :href="route('crud-genre.create')" :active="request()->routeIs('crud-genre.create')">
        </x-menu-item> --}} -->

        <x-menu-item title="Album" icon="fas fa-list" :href="route('crud-album.tampil')" :active="request()->routeIs('crud-album.tampil')">
        </x-menu-item>

        {{-- <x-menu-item title="Tambah Album" icon="fas fa-plus-circle" :href="route('crud-album.tambah')" :active="request()->routeIs('crud-album.tambah')">
        </x-menu-item> --}}

        
        <x-menu-item title="Record Label" icon="fas fa-list" :href="route('crud-recordlabel.tampil')" :active="request()->routeIs('crud-recordlabel.tampil')">
        </x-menu-item>

        {{-- <x-menu-item title="Tambah Record Label" icon="fas fa-plus-circle" :href="route('crud-recordlabel.tambah')" :active="request()->routeIs('crud-recordlabel.tambah')">
        </x-menu-item> --}}


        <x-menu-item title="Playlist" icon="fas fa-list" :href="route('crud-playlist.tampil')" :active="request()->routeIs('crud-playlist.tampil')">
        </x-menu-item>

        {{-- <x-menu-item title="Tambah Playlist" icon="fas fa-plus-circle" :href="route('crud-playlist.tambah')" :active="request()->routeIs('crud-playlist.tambah')">
        </x-menu-item> --}}
        
        @role('user')
        <x-menu-item title="Favorites" icon="fas fa-list" :href="route('crud-favorite.tampil')" :active="request()->routeIs('crud-favorite.tampil')">
        </x-menu-item>

        {{-- <x-menu-item title="Tambah Favorite" icon="fas fa-plus-circle" :href="route('crud-favorite.tambah')" :active="request()->routeIs('crud-favorite.tambah')">
        </x-menu-item> --}}
        @endrole

        <x-menu-item title="Show" icon="fas fa-list" :href="route('crud-show.tampil')" :active="request()->routeIs('crud-show.tampil')">
        </x-menu-item>

        {{-- <x-menu-item title="Tambah Show" icon="fas fa-plus-circle" :href="route('crud-show.tambah')" :active="request()->routeIs('crud-show.tambah')">
        </x-menu-item> --}}

        <x-menu-item title="Episode" icon="fas fa-list" :href="route('crud-episode.index')" :active="request()->routeIs('crud-episode.index')">
        </x-menu-item>

        {{-- <x-menu-item title="Tambah episode" icon="fas fa-plus-circle" :href="route('crud-episode.create')" :active="request()->routeIs('crud-episode.create')">
        </x-menu-item> --}}
        
        
        <x-menu-item title="REST API" icon="fas fa-list" :href="route('api-page')" :active="request()->routeIs('api-page')">
        </x-menu-item>

        <!-- <x-menu-item title="Album" icon="fas fa-list" :href="route('temp')" :active="request()->routeIs('temp')">
        </x-menu-item> -->
        <!-- <x-menu-item title="Record Label" icon="fas fa-list" :href="route('temp')" :active="request()->routeIs('temp')">
        </x-menu-item> -->
        <!-- <x-menu-item title="Playlist" icon="fas fa-list" :href="route('temp')" :active="request()->routeIs('temp')">
        </x-menu-item> -->
        <!-- <x-menu-item title="Favorites" icon="fas fa-list" :href="route('temp')" :active="request()->routeIs('temp')">
        </x-menu-item> -->

    <!-- </x-menu-tree> -->
    <!-- {{-- <x-menu-item title="Adminlte" icon="fas fa-plus-circle" href="/adminlte/index.html" active=''> -->
    <!-- </x-menu-item> --}} -->
@endsection
